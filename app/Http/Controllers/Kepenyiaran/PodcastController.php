<?php

namespace App\Http\Controllers\Kepenyiaran;

use App\Models\Podcast;
use App\Models\RefProgramSiar;
use App\Models\RefJenisProgramSiar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class PodcastController extends Controller
{
    // List
    public function index(Request $request)
    {
        $jenis_program = RefJenisProgramSiar::all();
        $program_siar = RefProgramSiar::all();
        $years = Podcast::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        $data = [
            'title' => 'Podcast',
            'jenis_program' => $jenis_program,
            'program_siar' => $program_siar,
            'years' => $years,
        ];

        return view('contents.kepenyiaran.podcast.list', $data);
    }

    public function data(Request $request)
    {
        $list = Podcast::select(DB::raw('*'))->with(['program_siar.jenis_program']);

        if ($request->jenis_program_id) {
            $list->whereHas('program_siar.jenis_program', function ($query) use ($request) {
                $query->where('id', $request->jenis_program_id);
            });
        }

        if ($request->program_id) {
            $list->where('program_id', $request->program_id);
        }

        if ($request->tahun) {
            $list->whereYear('tanggal', $request->tahun);
        }

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('encrypted_id', function ($row) {
                return Crypt::encryptString($row->id);
            })
            ->make();
    }

    // Get Program Siar
    public function getProgramSiar($jenis_program_id)
    {
        $program_siar = RefProgramSiar::where('jenis_program_id', $jenis_program_id)->get();
        return response()->json($program_siar);
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'jenis_program_id' => 'required|integer',
            'program_id' => 'required|integer',
            'judul' => 'required|string',
            'tanggal' => 'required|date',
            'link' => 'required|string',
        ]);

        try {
            $data = [
                'jenis_program_id' => $request->jenis_program_id,
                'program_id' => $request->program_id,
                'judul' => $request->judul,
                'tanggal' => $request->tanggal,
                'link' => $request->link,
            ];

            Podcast::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'jenis_program_id' => 'required|integer',
            'program_id' => 'required|integer',
            'judul' => 'required|string',
            'tanggal' => 'required|date',
            'link' => 'required|string',
        ]);

        try {
            $podcast = Podcast::find($request->id);
            $podcast->jenis_program_id = $request->jenis_program_id;
            $podcast->program_id = $request->program_id;
            $podcast->judul = $request->judul;
            $podcast->tanggal = $request->tanggal;
            $podcast->link = $request->link;

            if ($podcast->isDirty()) {
                $podcast->save();
            }

            if ($podcast->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Delete
    public function delete(Request $request)
    {
        try {
            $podcast = Podcast::find($request->id);
            $podcast->delete();

            if ($podcast->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

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

        $data = [
            'title' => 'Podcast',
            'jenis_program' => $jenis_program,
            'program_siar' => $program_siar,
        ];

        return view('contents.kepenyiaran.podcast.list', $data);
    }

    public function data(Request $request)
    {
        $list = Podcast::select(DB::raw('*'))->with(['program_siar.jenis_program']);

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
            'program_id' => 'required|int',
            'judul' => 'required|string',
            'tanggal' => 'required|date',
            'link' => 'required|string',
        ]);

        try {
            $data = [
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
            'program_id' => 'required|int',
            'judul' => 'required|string',
            'tanggal' => 'required|date',
            'link' => 'required|string',
        ]);

        try {
            $podcast = Podcast::find($request->id);
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

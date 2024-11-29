<?php

namespace App\Http\Controllers\Kepenyiaran;

use App\Models\ProgramSiar;
use App\Models\RefProgramSiar;
use App\Models\RefJenisProgramSiar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProgramSiarController extends Controller
{
    // List
    public function index(Request $request)
    {
        $jenis_program = RefJenisProgramSiar::all();
        $program_siar = RefProgramSiar::all();

        $data = [
            'title' => 'Program Siar',
            'jenis_program' => $jenis_program,
            'program_siar' => $program_siar,
        ];

        return view('contents.kepenyiaran.program-siar.list', $data);
    }

    public function data(Request $request)
    {
        $list = ProgramSiar::select(DB::raw('*'))->with(['program_siar.jenis_program']);

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
            'tahun' => 'required|integer',
            'order' => 'required|integer',
            'link' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $siar = RefProgramSiar::where('id', $request->program_id)->first();
            $jenis = RefJenisProgramSiar::where('id', $siar->id)->first();

            $data = [
                'jenis_program_id' => $request->jenis_program_id,
                'program_id' => $request->program_id,
                'tahun' => $request->tahun,
                'order' => $request->order,
                'link' => $request->link,
            ];

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $path = $file->store('public/uploads/programs/' . $request->tahun . '/' . $jenis->jenis . '/' . $siar->nama);

                $encodedPath = Storage::url($path);
                $encodedPath = str_replace([' ', '#'], ['%20', '%23'], $encodedPath);

                $data['filename'] = $originalName;
                $data['path'] = $encodedPath;
            }

            ProgramSiar::create($data);

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
            'tahun' => 'required|integer',
            'order' => 'required|integer',
            'link' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $program = ProgramSiar::find($request->id);
            $program->jenis_program_id = $request->jenis_program_id;
            $program->program_id = $request->program_id;
            $program->tahun = $request->tahun;
            $program->order = $request->order;
            $program->link = $request->link;

            $siar = RefProgramSiar::where('id', $request->program_id)->first();
            $jenis = RefJenisProgramSiar::where('id', $siar->id)->first();

            if ($request->hasFile('image')) {
                if ($program->path) {
                    $decodedPath = str_replace(['%20', '%23'], [' ', '#'], $program->path);

                    if (file_exists(public_path($decodedPath))) {
                        unlink(public_path($decodedPath));
                    }
                }

                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $path = $file->store('public/uploads/programs/' . $request->tahun . '/' . $jenis->jenis . '/' . $siar->nama);

                $encodedPath = Storage::url($path);
                $encodedPath = str_replace([' ', '#'], ['%20', '%23'], $encodedPath);

                $program->filename = $originalName;
                $program->path = $encodedPath;
            }

            if ($program->isDirty()) {
                $program->save();
            }

            if ($program->wasChanged()) {
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
            $program = ProgramSiar::find($request->id);

            if ($program) {
                if ($program->path) {
                    $decodedPath = str_replace(['%20', '%23'], [' ', '#'], $program->path);

                    if (file_exists(public_path($decodedPath))) {
                        unlink(public_path($decodedPath));
                    }
                }

                $program->delete();

                if ($program->trashed()) {
                    return response()->json(['status' => true], 200);
                }
            } else {
                return response()->json(['status' => false, 'msg' => 'Program Siar not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Switch Status
    public function switchStatus(Request $request)
    {
        try {
            $program = ProgramSiar::find($request->id);
            $program->is_active = $request->value;

            if ($program->isDirty()) {
                $program->save();
            }

            if ($program->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

<?php

namespace App\Http\Controllers\Kepenyiaran;

use App\Models\RefProgramSiar;
use App\Models\RefJenisProgramSiar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class RefProgramSiarController extends Controller
{
    // List
    public function index(Request $request)
    {
        $jenis_program = RefJenisProgramSiar::all();

        $data = [
            'title' => 'Referensi Program Siar',
            'jenis_program' => $jenis_program
        ];

        return view('contents.kepenyiaran.program-siar.program.list', $data);
    }

    public function data(Request $request)
    {
        $list = RefProgramSiar::select(DB::raw('*'))->with(['jenis_program']);

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('encrypted_id', function ($row) {
                return Crypt::encryptString($row->id);
            })
            ->make();
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'jenis_program_id' => 'required|integer',
            'nama' => 'required|string',
        ]);

        try {
            $data = [
                'jenis_program_id' => $request->jenis_program_id,
                'nama' => $request->nama,
            ];

            RefProgramSiar::create($data);

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
            'nama' => 'required|string',
        ]);

        try {
            $program = RefProgramSiar::find($request->id);
            $program->jenis_program_id = $request->jenis_program_id;
            $program->nama = $request->nama;

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
            $program = RefProgramSiar::find($request->id);
            $program->delete();

            if ($program->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    public function switchStatus(Request $request)
    {
        try {
            $program = RefProgramSiar::find($request->id);
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

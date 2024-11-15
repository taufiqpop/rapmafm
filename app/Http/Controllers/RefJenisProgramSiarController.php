<?php

namespace App\Http\Controllers;

use App\Models\RefJenisProgramSiar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class RefJenisProgramSiarController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Referensi Jenis Program Siar'
        ];

        return view('contents.program-siar.jenis.list', $data);
    }

    public function data(Request $request)
    {
        $list = RefJenisProgramSiar::select(DB::raw('*'));

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
            'jenis' => 'required|string',
            'key' => 'required|string',
        ]);

        try {
            $data = [
                'jenis' => $request->jenis,
                'key' => $request->key,
            ];

            RefJenisProgramSiar::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string',
            'key' => 'required|string',
        ]);

        try {
            $program = RefJenisProgramSiar::find($request->id);
            $program->jenis = $request->jenis;
            $program->key = $request->key;

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
            $program = RefJenisProgramSiar::find($request->id);
            $program->delete();

            if ($program->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

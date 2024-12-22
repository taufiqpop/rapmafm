<?php

namespace App\Http\Controllers\GMPA;

use App\Models\RefDivisi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class RefDivisiController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Divisi'
        ];

        return view('contents.gmpa.divisi.list', $data);
    }

    public function data(Request $request)
    {
        $list = RefDivisi::select(DB::raw('*'));

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
            'nama' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try {
            $data = [
                'nama' => $request->nama,
                'keterangan' => $request->keterangan,
            ];

            RefDivisi::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try {
            $divisi = RefDivisi::find($request->id);
            $divisi->nama = $request->nama;
            $divisi->keterangan = $request->keterangan;

            if ($divisi->isDirty()) {
                $divisi->save();
            }

            if ($divisi->wasChanged()) {
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
            $divisi = RefDivisi::find($request->id);
            $divisi->delete();

            if ($divisi->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

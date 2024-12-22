<?php

namespace App\Http\Controllers\GMPA;

use App\Models\RefSubDivisi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class RefSubDivisiController extends Controller
{
    // List
    public function index($id)
    {
        $data = [
            'title' => 'Sub Divisi',
            'id' => $id
        ];

        return view('contents.gmpa.divisi.sub-divisi.list', $data);
    }

    public function data($id)
    {
        $decryptID = Crypt::decryptString($id);
        $list = RefSubDivisi::select(DB::raw('*'))->where('divisi_id', $decryptID)->with(['divisi']);

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('encrypted_id', function ($row) {
                return Crypt::encryptString($row->id);
            })
            ->make();
    }

    // Store
    public function store(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try {
            $data = [
                'divisi_id' => Crypt::decryptString($id),
                'nama' => $request->nama,
                'keterangan' => $request->keterangan,
            ];

            RefSubDivisi::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:ref_sub_divisi,id',
            'nama' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try {
            $divisi = RefSubDivisi::find($request->id);
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
            $divisi = RefSubDivisi::find($request->id);
            $divisi->delete();

            if ($divisi->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Inventarisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class InventarisasiController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Inventarisasi'
        ];

        return view('contents.inventarisasi.list', $data);
    }

    public function data(Request $request)
    {
        $list = Inventarisasi::select(DB::raw('*'));

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
            'barang' => 'required|string',
            'kode' => 'required|string',
            'nomor' => 'required|string',
            'tahun' => 'required|string',
            'kondisi' => 'required|string',
        ]);

        try {
            $data = [
                'barang' => $request->barang,
                'kode' => $request->kode,
                'nomor' => $request->nomor,
                'kondisi' => $request->kondisi,
                'tahun' => $request->tahun,
            ];

            Inventarisasi::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'barang' => 'required|string',
            'kode' => 'required|string',
            'nomor' => 'required|string',
            'tahun' => 'required|string',
            'kondisi' => 'required|string',
        ]);

        try {
            $inventarisasi = Inventarisasi::find($request->id);
            $inventarisasi->barang = $request->barang;
            $inventarisasi->kode = $request->kode;
            $inventarisasi->nomor = $request->nomor;
            $inventarisasi->kondisi = $request->kondisi;
            $inventarisasi->tahun = $request->tahun;

            if ($inventarisasi->isDirty()) {
                $inventarisasi->save();
            }

            if ($inventarisasi->wasChanged()) {
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
            $inventarisasi = Inventarisasi::find($request->id);
            $inventarisasi->delete();

            if ($inventarisasi->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

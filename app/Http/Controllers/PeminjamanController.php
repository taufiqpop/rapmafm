<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class PeminjamanController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Peminjaman'
        ];

        return view('contents.peminjaman.list', $data);
    }

    public function data(Request $request)
    {
        $list = Peminjaman::select(DB::raw('*'));

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
            'jumlah' => 'required|string',
            'nama_peminjam' => 'required|string',
            'asal_peminjam' => 'required|string',
            'tgl_pinjam' => 'required|string',
            'tgl_kembali' => 'nullable|string',
            'fee' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $data = [
                'barang' => $request->barang,
                'jumlah' => $request->jumlah,
                'nama_peminjam' => $request->nama_peminjam,
                'asal_peminjam' => $request->asal_peminjam,
                'tgl_pinjam' => $request->tgl_pinjam,
                'tgl_kembali' => $request->tgl_kembali,
                'fee' => $request->fee,
                'keterangan' => $request->keterangan,
            ];

            Peminjaman::create($data);

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
            'jumlah' => 'required|string',
            'nama_peminjam' => 'required|string',
            'asal_peminjam' => 'required|string',
            'tgl_pinjam' => 'required|string',
            'tgl_kembali' => 'nullable|string',
            'fee' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $peminjaman = Peminjaman::find($request->id);
            $peminjaman->barang = $request->barang;
            $peminjaman->jumlah = $request->jumlah;
            $peminjaman->nama_peminjam = $request->nama_peminjam;
            $peminjaman->asal_peminjam = $request->asal_peminjam;
            $peminjaman->tgl_pinjam = $request->tgl_pinjam;
            $peminjaman->tgl_kembali = $request->tgl_kembali;
            $peminjaman->fee = $request->fee;
            $peminjaman->keterangan = $request->keterangan;

            if ($peminjaman->isDirty()) {
                $peminjaman->save();
            }

            if ($peminjaman->wasChanged()) {
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
            $peminjaman = Peminjaman::find($request->id);
            $peminjaman->delete();

            if ($peminjaman->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

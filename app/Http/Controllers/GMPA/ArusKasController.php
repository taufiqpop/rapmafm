<?php

namespace App\Http\Controllers\GMPA;

use App\Models\ArusKas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class ArusKasController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Arus Kas'
        ];

        return view('contents.gmpa.arus-kas.list', $data);
    }

    public function data(Request $request)
    {
        $saldo = 0;
        $list = ArusKas::select(DB::raw('*'))->orderBy('tanggal', 'asc');

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('saldo', function ($row) use (&$saldo) {
                $pemasukan = $row->pemasukan ?? 0;
                $pengeluaran = $row->pengeluaran ?? 0;
                $saldo += ($pemasukan - $pengeluaran);
                return $saldo;
            })
            ->addColumn('encrypted_id', function ($row) {
                return Crypt::encryptString($row->id);
            })
            ->make(true);
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'pemasukan' => 'nullable|integer',
            'pengeluaran' => 'nullable|integer',
        ]);

        try {
            $data = [
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'pemasukan' => $request->pemasukan,
                'pengeluaran' => $request->pengeluaran,
            ];

            ArusKas::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'pemasukan' => 'nullable|integer',
            'pengeluaran' => 'nullable|integer',
        ]);

        try {
            $arus_kas = ArusKas::find($request->id);
            $arus_kas->tanggal = $request->tanggal;
            $arus_kas->keterangan = $request->keterangan;
            $arus_kas->pemasukan = $request->pemasukan;
            $arus_kas->pengeluaran = $request->pengeluaran;

            if ($arus_kas->isDirty()) {
                $arus_kas->save();
            }

            if ($arus_kas->wasChanged()) {
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
            $arus_kas = ArusKas::find($request->id);
            $arus_kas->delete();

            if ($arus_kas->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}
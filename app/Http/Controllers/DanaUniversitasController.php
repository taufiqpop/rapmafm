<?php

namespace App\Http\Controllers;

use App\Models\DanaUniversitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class DanaUniversitasController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Dana Universitas'
        ];

        return view('contents.dana-universitas.list', $data);
    }

    public function data(Request $request)
    {
        $list = DanaUniversitas::select(DB::raw('*'))->orderBy('tanggal', 'asc');

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

            DanaUniversitas::create($data);

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
            $dana_universitas = DanaUniversitas::find($request->id);
            $dana_universitas->tanggal = $request->tanggal;
            $dana_universitas->keterangan = $request->keterangan;
            $dana_universitas->pemasukan = $request->pemasukan;
            $dana_universitas->pengeluaran = $request->pengeluaran;

            if ($dana_universitas->isDirty()) {
                $dana_universitas->save();
            }

            if ($dana_universitas->wasChanged()) {
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
            $dana_universitas = DanaUniversitas::find($request->id);
            $dana_universitas->delete();

            if ($dana_universitas->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

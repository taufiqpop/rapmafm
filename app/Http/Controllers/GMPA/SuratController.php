<?php

namespace App\Http\Controllers\GMPA;

use App\Models\Surat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class SuratController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Surat'
        ];

        return view('contents.gmpa.surat.list', $data);
    }

    public function data(Request $request)
    {
        $list = Surat::select(DB::raw('*'));

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
            'perihal' => 'required|string',
            'tanggal' => 'required|string',
            'asal_surat' => 'required|string',
            'nomor' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try {
            $data = [
                'perihal' => $request->perihal,
                'tanggal' => $request->tanggal,
                'asal_surat' => $request->asal_surat,
                'nomor' => $request->nomor,
                'keterangan' => $request->keterangan,
            ];

            Surat::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'perihal' => 'required|string',
            'tanggal' => 'required|string',
            'asal_surat' => 'required|string',
            'nomor' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try {
            $surat = Surat::find($request->id);
            $surat->perihal = $request->perihal;
            $surat->tanggal = $request->tanggal;
            $surat->asal_surat = $request->asal_surat;
            $surat->nomor = $request->nomor;
            $surat->keterangan = $request->keterangan;

            if ($surat->isDirty()) {
                $surat->save();
            }

            if ($surat->wasChanged()) {
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
            $surat = Surat::find($request->id);
            $surat->delete();

            if ($surat->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

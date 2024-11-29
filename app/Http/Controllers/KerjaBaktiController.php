<?php

namespace App\Http\Controllers;

use App\Models\KerjaBakti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class KerjaBaktiController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Kerja Bakti'
        ];

        return view('contents.kerja-bakti.list', $data);
    }

    public function data(Request $request)
    {
        $list = KerjaBakti::select(DB::raw('*'));

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
            'tujuan' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_crew' => 'nullable|integer',
            'jumlah_pengurus' => 'nullable|integer',
            'kendala' => 'nullable|string',
            'status' => 'required|string',
        ]);

        try {
            $data = [
                'tujuan' => $request->tujuan,
                'tanggal' => $request->tanggal,
                'jumlah_crew' => $request->jumlah_crew,
                'jumlah_pengurus' => $request->jumlah_pengurus,
                'kendala' => $request->kendala,
                'status' => $request->status,
            ];

            KerjaBakti::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'tujuan' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_crew' => 'nullable|integer',
            'jumlah_pengurus' => 'nullable|integer',
            'kendala' => 'nullable|string',
            'status' => 'required|string',
        ]);

        try {
            $kerja_bakti = KerjaBakti::find($request->id);
            $kerja_bakti->tujuan = $request->tujuan;
            $kerja_bakti->tanggal = $request->tanggal;
            $kerja_bakti->jumlah_crew = $request->jumlah_crew;
            $kerja_bakti->jumlah_pengurus = $request->jumlah_pengurus;
            $kerja_bakti->kendala = $request->kendala;
            $kerja_bakti->status = $request->status;

            if ($kerja_bakti->isDirty()) {
                $kerja_bakti->save();
            }

            if ($kerja_bakti->wasChanged()) {
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
            $kerja_bakti = KerjaBakti::find($request->id);
            $kerja_bakti->delete();

            if ($kerja_bakti->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

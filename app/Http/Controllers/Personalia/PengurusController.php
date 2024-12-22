<?php

namespace App\Http\Controllers\Personalia;

use App\Models\Members;
use App\Models\RefDivisi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class PengurusController extends Controller
{
    // List
    public function index(Request $request)
    {
        $ref_divisi = RefDivisi::all();

        $data = [
            'title' => 'Pengurus',
            'ref_divisi' => $ref_divisi
        ];

        return view('contents.personalia.members.pengurus.list', $data);
    }

    public function data(Request $request)
    {
        $list = Members::select(DB::raw('*'))->where('rank', 'Pengurus');

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('encrypted_id', function ($row) {
                return Crypt::encryptString($row->id);
            })
            ->make();
    }

    // Get Sub Divisi
    public function getSubDivisi($nama)
    {
        $divisi = RefDivisi::where('nama', $nama)->first();
    
        if (!$divisi) {
            return response()->json([], 404);
        }
    
        $sub_divisi = $divisi->sub_divisi;
        return response()->json($sub_divisi);
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string',
            'nickname' => 'required|string',
            'gender' => 'required|string',
            'divisi' => 'required|string',
            'sub_divisi' => 'required|string',
            'no_hp' => 'required|string',
            'fakultas' => 'required|string',
            'prodi' => 'required|string',
            'semester' => 'required|integer',
            'instagram' => 'required|string',
            'twitter' => 'required|string',
        ]);

        try {
            $data = [
                'rank' => 'Pengurus',
                'fullname' => $request->fullname,
                'nickname' => $request->nickname,
                'gender' => $request->gender,
                'divisi' => $request->divisi,
                'sub_divisi' => $request->sub_divisi,
                'no_hp' => $request->no_hp,
                'fakultas' => $request->fakultas,
                'prodi' => $request->prodi,
                'semester' => $request->semester,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
            ];

            Members::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string',
            'nickname' => 'required|string',
            'gender' => 'required|string',
            'divisi' => 'required|string',
            'sub_divisi' => 'required|string',
            'no_hp' => 'required|string',
            'fakultas' => 'required|string',
            'prodi' => 'required|string',
            'semester' => 'required|integer',
            'instagram' => 'required|string',
            'twitter' => 'required|string',
        ]);

        try {
            $pengurus = Members::find($request->id);
            $pengurus->rank = 'Pengurus';
            $pengurus->fullname = $request->fullname;
            $pengurus->nickname = $request->nickname;
            $pengurus->gender = $request->gender;
            $pengurus->divisi = $request->divisi;
            $pengurus->sub_divisi = $request->sub_divisi;
            $pengurus->no_hp = $request->no_hp;
            $pengurus->fakultas = $request->fakultas;
            $pengurus->prodi = $request->prodi;
            $pengurus->semester = $request->semester;
            $pengurus->instagram = $request->instagram;
            $pengurus->twitter = $request->twitter;

            if ($pengurus->isDirty()) {
                $pengurus->save();
            }

            if ($pengurus->wasChanged()) {
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
            $pengurus = Members::find($request->id);
            $pengurus->delete();

            if ($pengurus->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Change Rank
    public function changeRank(Request $request)
    {
        try {
            $pengurus = Members::find($request->id);
            $pengurus->rank = $request->rank;

            if ($pengurus->isDirty()) {
                $pengurus->save();
            }

            if ($pengurus->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Switch Status
    public function switchStatus(Request $request)
    {
        try {
            $pengurus = Members::find($request->id);
            $pengurus->is_active = $request->value;

            if ($pengurus->isDirty()) {
                $pengurus->save();
            }

            if ($pengurus->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

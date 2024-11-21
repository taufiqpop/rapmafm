<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class AlumniController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Alumni'
        ];

        return view('contents.members.alumni.list', $data);
    }

    public function data(Request $request)
    {
        $list = Alumni::select(DB::raw('*'));

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
            'fullname' => 'required|string',
            'nickname' => 'required|string',
            'gender' => 'required|string',
            'divisi' => 'required|string',
            'sub_divisi' => 'required|string',
            'no_hp' => 'nullable|string',
            'fakultas' => 'required|string',
            'prodi' => 'required|string',
            'tahun_kepengurusan' => 'required|string',
            'instagram' => 'required|string',
        ]);

        try {
            $data = [
                'fullname' => $request->fullname,
                'nickname' => $request->nickname,
                'gender' => $request->gender,
                'divisi' => $request->divisi,
                'sub_divisi' => $request->sub_divisi,
                'no_hp' => $request->no_hp,
                'fakultas' => $request->fakultas,
                'prodi' => $request->prodi,
                'tahun_kepengurusan' => $request->tahun_kepengurusan,
                'instagram' => $request->instagram,
            ];

            Alumni::create($data);

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
            'no_hp' => 'nullable|string',
            'fakultas' => 'required|string',
            'prodi' => 'required|string',
            'tahun_kepengurusan' => 'required|string',
            'instagram' => 'required|string',
        ]);

        try {
            $alumni = Alumni::find($request->id);
            $alumni->fullname = $request->fullname;
            $alumni->nickname = $request->nickname;
            $alumni->gender = $request->gender;
            $alumni->divisi = $request->divisi;
            $alumni->sub_divisi = $request->sub_divisi;
            $alumni->no_hp = $request->no_hp;
            $alumni->fakultas = $request->fakultas;
            $alumni->prodi = $request->prodi;
            $alumni->tahun_kepengurusan = $request->tahun_kepengurusan;
            $alumni->instagram = $request->instagram;

            if ($alumni->isDirty()) {
                $alumni->save();
            }

            if ($alumni->wasChanged()) {
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
            $alumni = Alumni::find($request->id);
            $alumni->delete();

            if ($alumni->trashed()) {
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
            $alumni = Alumni::find($request->id);
            $alumni->is_active = $request->value;

            if ($alumni->isDirty()) {
                $alumni->save();
            }

            if ($alumni->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

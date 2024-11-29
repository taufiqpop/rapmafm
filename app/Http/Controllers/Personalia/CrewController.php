<?php

namespace App\Http\Controllers\Personalia;

use App\Models\Crew;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class CrewController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Crew'
        ];

        return view('contents.personalia.members.crew.list', $data);
    }

    public function data(Request $request)
    {
        $list = Crew::select(DB::raw('*'));

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
            'tahun_masuk' => 'required|integer',
            'no_hp' => 'required|integer',
            'fakultas' => 'required|string',
            'prodi' => 'required|string',
            'semester' => 'required|integer',
            'instagram' => 'required|string',
            'twitter' => 'required|string',
        ]);

        try {
            $data = [
                'fullname' => $request->fullname,
                'nickname' => $request->nickname,
                'gender' => $request->gender,
                'tahun_masuk' => $request->tahun_masuk,
                'no_hp' => $request->no_hp,
                'fakultas' => $request->fakultas,
                'prodi' => $request->prodi,
                'semester' => $request->semester,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
            ];

            Crew::create($data);

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
            'tahun_masuk' => 'required|integer',
            'no_hp' => 'required|integer',
            'fakultas' => 'required|string',
            'prodi' => 'required|string',
            'semester' => 'required|integer',
            'instagram' => 'required|string',
            'twitter' => 'required|string',
        ]);

        try {
            $crew = Crew::find($request->id);
            $crew->fullname = $request->fullname;
            $crew->nickname = $request->nickname;
            $crew->gender = $request->gender;
            $crew->tahun_masuk = $request->tahun_masuk;
            $crew->no_hp = $request->no_hp;
            $crew->fakultas = $request->fakultas;
            $crew->prodi = $request->prodi;
            $crew->semester = $request->semester;
            $crew->instagram = $request->instagram;
            $crew->twitter = $request->twitter;

            if ($crew->isDirty()) {
                $crew->save();
            }

            if ($crew->wasChanged()) {
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
            $crew = Crew::find($request->id);
            $crew->delete();

            if ($crew->trashed()) {
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
            $crew = Crew::find($request->id);
            $crew->is_active = $request->value;

            if ($crew->isDirty()) {
                $crew->save();
            }

            if ($crew->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

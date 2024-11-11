<?php

namespace App\Http\Controllers;

use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class StrukturOrganisasiController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Struktur Organisasi'
        ];

        return view('contents.struktur-organisasi.list', $data);
    }

    public function data(Request $request)
    {
        $list = StrukturOrganisasi::select(DB::raw('*'));

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
            'divisi' => 'required|string',
            'pangkat' => 'required|string',
            'tahun' => 'required|string',
            'order' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $data = [
                'divisi' => $request->divisi,
                'pangkat' => $request->pangkat,
                'tahun' => $request->tahun,
                'order' => $request->order,
            ];

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $path = $file->store('public/uploads/divisi-umum/struktur-organisasi');

                $data['filename'] = $originalName;
                $data['path'] = Storage::url($path);
            }

            StrukturOrganisasi::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'divisi' => 'required|string',
            'pangkat' => 'required|string',
            'tahun' => 'required|string',
            'order' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $struktur = StrukturOrganisasi::find($request->id);
            $struktur->divisi = $request->divisi;
            $struktur->pangkat = $request->pangkat;
            $struktur->tahun = $request->tahun;
            $struktur->order = $request->order;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $path = $file->store('public/uploads/divisi-umum/struktur-organisasi');

                $struktur->filename = $originalName;
                $struktur->path = Storage::url($path);
            }

            if ($struktur->isDirty()) {
                $struktur->save();
            }

            if ($struktur->wasChanged()) {
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
            $struktur = StrukturOrganisasi::find($request->id);
            $struktur->delete();

            if ($struktur->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    public function switchStatus(Request $request)
    {
        try {
            $user = StrukturOrganisasi::find($request->id);
            $user->is_active = $request->value;

            if ($user->isDirty()) {
                $user->save();
            }

            if ($user->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

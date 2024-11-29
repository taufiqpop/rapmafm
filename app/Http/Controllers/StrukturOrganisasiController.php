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
            'tahun' => 'required|integer',
            'order' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
                $path = $file->store('public/uploads/struktur-organisasi/' . $request->tahun);

                $encodedPath = Storage::url($path);
                $encodedPath = str_replace([' ', '#'], ['%20', '%23'], $encodedPath);

                $data['filename'] = $originalName;
                $data['path'] = $encodedPath;
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
            'tahun' => 'required|integer',
            'order' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $struktur = StrukturOrganisasi::find($request->id);
            $struktur->divisi = $request->divisi;
            $struktur->pangkat = $request->pangkat;
            $struktur->tahun = $request->tahun;
            $struktur->order = $request->order;

            if ($request->hasFile('image')) {
                if ($struktur->path) {
                    $decodedPath = str_replace(['%20', '%23'], [' ', '#'], $struktur->path);

                    if (file_exists(public_path($decodedPath))) {
                        unlink(public_path($decodedPath));
                    }
                }

                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $path = $file->store('public/uploads/struktur-organisasi/' . $request->tahun);

                $encodedPath = Storage::url($path);
                $encodedPath = str_replace([' ', '#'], ['%20', '%23'], $encodedPath);

                $struktur->filename = $originalName;
                $struktur->path = $encodedPath;
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

            if ($struktur) {
                if ($struktur->path) {
                    $decodedPath = str_replace(['%20', '%23'], [' ', '#'], $struktur->path);

                    if (file_exists(public_path($decodedPath))) {
                        unlink(public_path($decodedPath));
                    }
                }

                $struktur->delete();

                if ($struktur->trashed()) {
                    return response()->json(['status' => true], 200);
                }
            } else {
                return response()->json(['status' => false, 'msg' => 'Data not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Switch Status
    public function switchStatus(Request $request)
    {
        try {
            $struktur = StrukturOrganisasi::find($request->id);
            $struktur->is_active = $request->value;

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
}

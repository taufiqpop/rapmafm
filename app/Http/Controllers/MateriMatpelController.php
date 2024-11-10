<?php

namespace App\Http\Controllers;

use App\Models\MateriMatpel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MateriMatpelController extends Controller
{
    // List Materi Mata Pelajaran
    public function index()
    {
        $data = [
            'title' => 'Materi Mata Pelajaran'
        ];

        return view('contents.materi_matpel.list', $data);
    }

    public function data()
    {
        $list = MateriMatpel::all();

        return DataTables::of($list)
            ->addIndexColumn()
            ->make();
    }

    // Store Materi Mata Pelajaran
    public function store(Request $request)
    {
        try {
            $data = [
                'nama_materi' => $request->nama_materi,
            ];

            MateriMatpel::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update Materi Mata Pelajaran
    public function update(Request $request)
    {
        try {
            $materi_matpel = MateriMatpel::findOrFail($request->id);
            $materi_matpel->nama_materi = $request->nama_materi;

            if ($materi_matpel->isDirty()) {
                $materi_matpel->save();
            }

            if ($materi_matpel->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Delete Materi Mata Pelajaran
    public function delete(Request $request)
    {
        try {
            $materi_matpel = MateriMatpel::findOrFail($request->id);
            $materi_matpel->delete();

            if ($materi_matpel->trashed()) {
                return response()->json(['status' => true], 200);
            }

            return response()->json(['status' => false, 'msg' => 'Failed to delete the record.'], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

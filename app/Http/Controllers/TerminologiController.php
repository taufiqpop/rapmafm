<?php

namespace App\Http\Controllers;

use App\Models\Terminologi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TerminologiController extends Controller
{
    // List Terminologi
    public function index()
    {
        $data = [
            'title' => 'Terminologi'
        ];

        return view('contents.terminologi.list', $data);
    }

    public function data()
    {
        $list = Terminologi::all();

        return DataTables::of($list)
            ->addIndexColumn()
            ->make();
    }

    // Store Terminologi
    public function store(Request $request)
    {
        $request->validate([
            'nama_pdf' => 'required|mimes:pdf|max:2048',
            'logo' => 'required|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $data = [
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'nama_pdf' => $request->file('nama_pdf')->store('uploads/terminologi/pdf', 'public'),
                'logo' => $request->file('logo')->store('uploads/terminologi/logo', 'public'),
            ];

            Terminologi::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update Terminologi
    public function update(Request $request)
    {
        $request->validate([
            'nama_pdf' => 'nullable|mimes:pdf|max:2048',
            'logo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $terminologi = Terminologi::findOrFail($request->id);
            $terminologi->nama = $request->nama;
            $terminologi->deskripsi = $request->deskripsi;

            if ($request->hasFile('nama_pdf')) {
                if ($terminologi->nama_pdf) {
                    Storage::disk('public')->delete($terminologi->nama_pdf);
                }
                $terminologi->nama_pdf = $request->file('nama_pdf')->store('uploads/terminologi/pdf', 'public');
            }

            if ($request->hasFile('logo')) {
                if ($terminologi->logo) {
                    Storage::disk('public')->delete($terminologi->logo);
                }
                $terminologi->logo = $request->file('logo')->store('uploads/terminologi/logo', 'public');
            }

            if ($terminologi->isDirty()) {
                $terminologi->save();
            }

            if ($terminologi->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Delete Terminologi
    public function delete(Request $request)
    {
        try {
            $terminologi = Terminologi::findOrFail($request->id);

            if ($terminologi->nama_pdf && Storage::disk('public')->exists($terminologi->nama_pdf)) {
                Storage::disk('public')->delete($terminologi->nama_pdf);
            }

            if ($terminologi->logo && Storage::disk('public')->exists($terminologi->logo)) {
                Storage::disk('public')->delete($terminologi->logo);
            }

            $terminologi->delete();

            if ($terminologi->trashed()) {
                return response()->json(['status' => true], 200);
            }

            return response()->json(['status' => false, 'msg' => 'Failed to delete the record.'], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

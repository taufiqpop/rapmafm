<?php

namespace App\Http\Controllers;

use App\Models\Inventarisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class InventarisasiController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Inventarisasi'
        ];

        return view('contents.inventarisasi.list', $data);
    }

    public function data(Request $request)
    {
        $list = Inventarisasi::select(DB::raw('*'));

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
            'nama' => 'required|string',
            'email' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            $data = [
                'nama' => $request->nama,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ];

            Inventarisasi::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            $inventarisasi = Inventarisasi::find($request->id);
            $inventarisasi->nama = $request->nama;
            $inventarisasi->email = $request->email;
            $inventarisasi->subject = $request->subject;
            $inventarisasi->message = $request->message;

            if ($inventarisasi->isDirty()) {
                $inventarisasi->save();
            }

            if ($inventarisasi->wasChanged()) {
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
            $inventarisasi = Inventarisasi::find($request->id);
            $inventarisasi->delete();

            if ($inventarisasi->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

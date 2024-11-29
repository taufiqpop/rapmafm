<?php

namespace App\Http\Controllers\Umum;

use App\Models\Pemancar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class PemancarController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Pemancar'
        ];

        return view('contents.umum.pemancar.list', $data);
    }

    public function data(Request $request)
    {
        $list = Pemancar::select(DB::raw('*'));

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

            Pemancar::create($data);

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
            $pemancar = Pemancar::find($request->id);
            $pemancar->nama = $request->nama;
            $pemancar->email = $request->email;
            $pemancar->subject = $request->subject;
            $pemancar->message = $request->message;

            if ($pemancar->isDirty()) {
                $pemancar->save();
            }

            if ($pemancar->wasChanged()) {
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
            $pemancar = Pemancar::find($request->id);
            $pemancar->delete();

            if ($pemancar->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

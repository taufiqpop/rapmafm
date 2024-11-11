<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class PesanController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Pesan'
        ];

        return view('contents.pesan.list', $data);
    }

    public function data(Request $request)
    {
        $list = Pesan::select(DB::raw('*'));

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
            'email' => 'required|string|email|unique:pesan,email',
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

            Pesan::create($data);

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
            'email' => ['required', Rule::unique('pesan', 'email')->ignore($request->id)],
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            $pesan = Pesan::find($request->id);
            $pesan->nama = $request->nama;
            $pesan->email = $request->email;
            $pesan->subject = $request->subject;
            $pesan->message = $request->message;

            if ($pesan->isDirty()) {
                $pesan->save();
            }

            if ($pesan->wasChanged()) {
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
            $pesan = Pesan::find($request->id);
            $pesan->delete();

            if ($pesan->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

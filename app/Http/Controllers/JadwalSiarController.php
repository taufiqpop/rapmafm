<?php

namespace App\Http\Controllers;

use App\Models\JadwalSiar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalSiarController extends Controller
{
    // Mode Views
    public function index(Request $request)
    {
        $jadwal = JadwalSiar::first();

        $data = [
            'title' => 'Jadwal Siar',
            'jadwal' => $jadwal,
        ];

        return view('contents.jadwal-siar.index', $data);
    }

    // Mode Edit
    public function edit(Request $request)
    {
        $jadwal = JadwalSiar::first();

        $data = [
            'title' => 'Edit Jadwal Siar',
            'jadwal' => $jadwal,
        ];

        return view('contents.jadwal-siar.edit', $data);
    }

    // Update Custom (Autosave)
    function update_custom()
    {
        $id = request()->post('id');
        $kolom = request()->post('kolom');
        $tabel = request()->post('tabel');
        $value = request()->post('value');

        DB::enableQueryLog();
        DB::beginTransaction();
        try {
            DB::select(
                "UPDATE $tabel SET $kolom = '$value' WHERE id = '$id'"
            );

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan Data',
                'query' => DB::getQueryLog()
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}

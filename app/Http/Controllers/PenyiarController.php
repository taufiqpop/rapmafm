<?php

namespace App\Http\Controllers;

use App\Models\RefJenisProgramSiar;
use App\Models\RefProgramSiar;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyiarController extends Controller
{
    public function index(Request $request)
    {
        $penyiar = Settings::first();
        $jenisProgram = RefJenisProgramSiar::all();
        $programSiar = RefProgramSiar::where('jenis_program_id', $penyiar->jenis_program_id)->where('is_active', 1)->get();

        $data = [
            'title' => 'Penyiar',
            'penyiar' => $penyiar,
            'jenisProgram' => $jenisProgram,
            'programSiar' => $programSiar,
        ];

        return view('contents.penyiar.index', $data);
    }

    // Get Program Siar
    public function getProgramSiar($jenis_program_id)
    {
        $program_siar = RefProgramSiar::where('jenis_program_id', $jenis_program_id)->get();
        return response()->json($program_siar);
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

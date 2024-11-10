<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Blueprint;
use App\Models\MateriBlueprint;
use App\Models\IndikatorBlueprint;
use App\Models\SekolahHasMateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class BlueprintController extends Controller
{
    // Data Blueprint
    public function data(Request $request)
    {
        $list = Blueprint::select(DB::raw('*'))->where('sekolah_id', $request->sekolah_id);

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('encrypted_id', function ($row) {
                return Crypt::encryptString($row->id);
            })
            ->make();
    }

    // Materi Blueprint (Kognitif)
    public function kognitif($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $blueprint = Blueprint::with('materi')->findOrFail($id);

        $data = [
            'title' => 'Materi Kisi-Kisi',
            'blueprint' => $blueprint,
        ];

        return view('contents.perumusan.blueprint.kognitif', $data);
    }

    // Materi Blueprint (Afektif)
    public function afektif($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $blueprint = Blueprint::with('materi')->findOrFail($id);

        $data = [
            'title' => 'Materi Kisi-Kisi',
            'blueprint' => $blueprint,
        ];

        return view('contents.perumusan.blueprint.afektif', $data);
    }

    // Materi Blueprint (Psikomotorik)
    public function psikomotorik($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $blueprint = Blueprint::with('materi')->findOrFail($id);

        $data = [
            'title' => 'Materi Kisi-Kisi',
            'blueprint' => $blueprint,
        ];

        return view('contents.perumusan.blueprint.psikomotorik', $data);
    }

    // Materi Blueprint
    public function materi(Request $request)
    {
        $list = MateriBlueprint::with(['indikator'])->select(DB::raw('*'))->where('blueprint_id', $request->blueprint_id);

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('encrypted_id', function ($row) {
                return Crypt::encryptString($row->id);
            })
            ->make();
    }

    // Store Materi
    public function materi_store(Request $request)
    {
        try {
            $blueprint_id = $request->blueprint_id;

            $materi = MateriBlueprint::create([
                'blueprint_id' => $blueprint_id,
                'materi' => $request->materi,
                'nama_siswa' => $request->nama_siswa,
            ]);

            $materi_blueprint_id = $materi->id;
            IndikatorBlueprint::create([
                'materi_blueprint_id' => $materi_blueprint_id
            ]);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Delete Materi
    public function materi_delete(Request $request)
    {
        try {
            $materi = MateriBlueprint::find($request->id);
            $materi->delete();

            if ($materi->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Store Target
    public function target_store(Request $request)
    {
        $request->validate([
            'target_pengetahuan' => 'required',
        ]);

        try {
            $materi_blueprint_id = $request->materi_blueprint_id;

            IndikatorBlueprint::create([
                'materi_blueprint_id' => $materi_blueprint_id,
                'target_pengetahuan' => $request->target_pengetahuan,
            ]);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Delete Target
    public function target_delete(Request $request)
    {
        try {
            $target_pengetahuan = IndikatorBlueprint::find($request->id);

            if (!$target_pengetahuan) {
                return response()->json(['status' => false, 'msg' => 'Indikator tidak ditemukan'], 404);
            }

            $target_pengetahuan->delete();

            if ($target_pengetahuan->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Export PDF Blueprint
    public function download($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $blueprints = Blueprint::findOrFail($id);
        $sekolah = Sekolah::findOrFail($blueprints->sekolah_id);
        $materiBlueprints = MateriBlueprint::where('blueprint_id', $id)->with('indikator')->get();
        $materiPelajaran = SekolahHasMateri::where('sekolah_id', $blueprints->sekolah_id)->with('materi_matpel')->get();

        $data = [
            'blueprints' => $blueprints,
            'sekolah' => $sekolah,
            'materiBlueprints' => $materiBlueprints,
            'materiPelajaran' => $materiPelajaran,
        ];

        $pdf = FacadePdf::loadView('contents.pdf.downloadBlueprint', $data);
        return $pdf->download('BLUEPRINT_' . $blueprints->ranah_penilaian . '_' . $sekolah->kelas . '_' . $sekolah->nama . '.pdf');
    }

    // Update Custom (Autosave)
    function update_custom()
    {
        $id = request()->post('id');
        $kolom = request()->post('kolom');
        $tabel = request()->post('tabel');
        $value = request()->post('value');
        $bentuk_lainnya = request()->post('bentuk_lainnya', null);

        DB::enableQueryLog();
        DB::beginTransaction();
        try {
            if ($kolom == 'bobot') {
                $totalBobot = DB::table($tabel)
                    ->where('id', '!=', $id)
                    ->sum('bobot');

                $totalBobot += floatval($value);

                if ($totalBobot > 100) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Total Bobot tidak boleh lebih dari 100%'
                    ]);
                }
            }

            if ($kolom == 'bentuk' && $value != 'Lainnya') {
                DB::table($tabel)
                    ->where('id', $id)
                    ->update(['bentuk_lainnya' => null]);
            }

            if ($kolom == 'bentuk' && $value == 'Lainnya') {
                DB::table($tabel)
                    ->where('id', $id)
                    ->update(['bentuk_lainnya' => $bentuk_lainnya]);
            }

            DB::table($tabel)
                ->where('id', $id)
                ->update([$kolom => $value]);

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

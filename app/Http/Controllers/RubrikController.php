<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Blueprint;
use App\Models\MateriBlueprint;
use App\Models\SekolahHasMateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class RubrikController extends Controller
{
    // Data Rubrik
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

    // Materi Rubrik (Kognitif)
    public function kognitif($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $blueprint = Blueprint::with('materi')->findOrFail($id);

        $data = [
            'title' => 'Materi Rubrik',
            'blueprint' => $blueprint,
        ];

        return view('contents.perumusan.rubrik.kognitif', $data);
    }

    // Materi Rubrik (Afektif)
    public function afektif($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $blueprint = Blueprint::with('materi')->findOrFail($id);

        $data = [
            'title' => 'Materi Rubrik',
            'blueprint' => $blueprint,
        ];

        return view('contents.perumusan.rubrik.afektif', $data);
    }

    // Materi Rubrik (Psikomotorik)
    public function psikomotorik($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $blueprint = Blueprint::with('materi')->findOrFail($id);

        $data = [
            'title' => 'Materi Rubrik',
            'blueprint' => $blueprint,
        ];

        return view('contents.perumusan.rubrik.psikomotorik', $data);
    }

    // Materi Rubrik
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

    // Export PDF Rubrik
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

        $pdf = FacadePdf::loadView('contents.pdf.downloadRubrik', $data);
        return $pdf->download('RUBRIK_' . $blueprints->ranah_penilaian . '_' . $sekolah->kelas . '_' . $sekolah->nama . '.pdf');
    }
}

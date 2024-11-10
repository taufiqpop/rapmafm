<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\Blueprint;
use App\Models\Dokumentasi;
use App\Models\MateriBlueprint;
use App\Models\SekolahHasMateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use setasign\Fpdi\Fpdi;

class KetercapaianController extends Controller
{
    protected $im;

    public function __construct()
    {
        $this->im = imagecreate(200, 200);
    }

    // List Ketercapaian
    public function index()
    {
        $user = Auth::user();
        $sekolah = Sekolah::where('user_id', $user->id)->get();

        $data = [
            'title' => 'Ketercapaian Tujuan & Kriteria Sukses',
            'sekolah' => $sekolah,
        ];

        return view('contents.ketercapaian.list', $data);
    }

    public function data(Request $request)
    {
        $user_id = Auth::id();
        $list = Sekolah::with(['materi_pelajaran.materi_matpel'])
            ->where('user_id', $user_id)
            ->where('is_archived', 0);

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('encrypted_id', function ($row) {
                return Crypt::encryptString($row->id);
            })
            ->addColumn('materi_pelajaran', function ($row) {
                return $row->materi_pelajaran->map(function ($item) {
                    return $item->materi_matpel->nama_materi;
                })->implode(', ');
            })
            ->make();
    }

    // Edit Ketercapaian
    public function edit($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $sekolah = Sekolah::where('id', $id)->firstOrFail();

        $data = [
            'title' => 'Ketercapaian Tujuan & Kriteria Sukses',
            'sekolah' => $sekolah,
        ];

        return view('contents.ketercapaian.form', $data);
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
                "UPDATE $tabel
                        set $kolom = '$value'
                        where id = '$id'"
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

    // Download Ketercapaian
    private function createPieChartImage($data, $path)
    {
        $imageWidth = 200;
        $imageHeight = 200;
        $im = imagecreatetruecolor($imageWidth, $imageHeight);

        $white = imagecolorallocate($im, 255, 255, 255);

        $red = imagecolorallocate($im, 255, 0, 0);
        $orange = imagecolorallocate($im, 255, 165, 0);
        $yellow = imagecolorallocate($im, 255, 255, 0);
        $green = imagecolorallocate($im, 0, 255, 0);
        $blue = imagecolorallocate($im, 0, 0, 255);
        $black = imagecolorallocate($im, 0, 0, 0);

        imagefill($im, 0, 0, $white);

        $total = array_sum($data);
        $startAngle = 0;

        foreach ($data as $category => $value) {
            if ($value > 0) {
                $endAngle = $startAngle + ($value / $total) * 360;
                imagefilledarc($im, $imageWidth / 2, $imageHeight / 2, $imageWidth, $imageHeight, $startAngle, $endAngle, $this->getColorByCategory($category, $im), IMG_ARC_PIE);
                $startAngle = $endAngle;
            }
        }

        imagepng($im, $path);
        imagedestroy($im);
    }

    private function getColorByCategory($category, $im)
    {
        switch ($category) {
            case 'dibawah60':
                return imagecolorallocate($im, 255, 0, 0); // Red
            case 'antara6070':
                return imagecolorallocate($im, 255, 165, 0); // Orange
            case 'antara7080':
                return imagecolorallocate($im, 255, 255, 0); // Yellow
            case 'antara8090':
                return imagecolorallocate($im, 0, 0, 255); // Blue
            case 'diatas90':
                return imagecolorallocate($im, 0, 255, 0); // Green
            default:
                return imagecolorallocate($im, 0, 0, 0); // Black
        }
    }

    public function downloadKetercapaian($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $sekolah = Sekolah::findOrFail($id);
        $blueprints = Blueprint::where('sekolah_id', $id)->get();
        $blueprintID = $blueprints->pluck('id');
        $materiBlueprints = MateriBlueprint::whereIn('blueprint_id', $blueprintID)->with('indikator')->get();
        $siswa = Siswa::where('sekolah_id', $id)->get();
        $dokumentasi = Dokumentasi::where('sekolah_id', $id)->get();
        $materiPelajaran = SekolahHasMateri::where('sekolah_id', $id)->with('materi_matpel')->get();

        $data = [
            'blueprints' => $blueprints,
            'sekolah' => $sekolah,
            'materiBlueprints' => $materiBlueprints,
            'siswa' => $siswa,
            'dokumentasi' => $dokumentasi,
            'materiPelajaran' => $materiPelajaran,
        ];

        $pieChartData = [
            'dibawah60' => $siswa->filter(fn($item) => $item->skor_akhir < 60)->count(),
            'antara6070' => $siswa->filter(fn($item) => $item->skor_akhir >= 61 && $item->skor_akhir <= 70)->count(),
            'antara7080' => $siswa->filter(fn($item) => $item->skor_akhir >= 71 && $item->skor_akhir <= 80)->count(),
            'antara8090' => $siswa->filter(fn($item) => $item->skor_akhir >= 81 && $item->skor_akhir <= 90)->count(),
            'diatas90' => $siswa->filter(fn($item) => $item->skor_akhir > 90)->count(),
        ];

        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $pieChartImagePath = $tempDir . '/pieChart.png';
        $this->createPieChartImage($pieChartData, $pieChartImagePath);

        // 1. PDF (Blueprint)
        $pdfBlueprint = FacadePdf::loadView('contents.pdf.ketercapaianBlueprint', $data);
        $pdfBlueprintPath = $tempDir . '/blueprint.pdf';
        $pdfBlueprint->save($pdfBlueprintPath);

        // 2. PDF (Rubrik)
        $pdfRubrik = FacadePdf::loadView('contents.pdf.ketercapaianRubrik', $data);
        $pdfRubrikPath = $tempDir . '/rubrik.pdf';
        $pdfRubrik->save($pdfRubrikPath);

        // 3. PDF (Soal) - Optional
        $uploadedFileExists = false;
        if ($sekolah->file_soal) {
            $uploadedFilePath = storage_path('app/public/' . $sekolah->file_soal);
            if (file_exists($uploadedFilePath)) {
                $pdfUploaded = new Fpdi();
                $pageCount = $pdfUploaded->setSourceFile($uploadedFilePath);

                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $templateId = $pdfUploaded->importPage($pageNo);
                    $size = $pdfUploaded->getTemplateSize($templateId);

                    // Orientation
                    $isLandscape = $size['width'] > $size['height'];
                    $pdfUploaded->addPage($isLandscape ? 'L' : 'P', [$size['width'], $size['height']]);
                    $pdfUploaded->useTemplate($templateId);
                }

                $uploadedFilePathTemp = $tempDir . '/uploaded.pdf';
                $pdfUploaded->Output($uploadedFilePathTemp, 'F');
                $uploadedFileExists = true;
            }
        }

        // 4. PDF (Dokumentasi) - Optional
        $dokumenExists = false;
        if ($dokumentasi->isNotEmpty()) {
            $pdfDokumentasi = FacadePdf::loadView('contents.pdf.ketercapaianDokumentasi', $data);
            $pdfDokumentasiPath = $tempDir . '/dokumentasi.pdf';
            $pdfDokumentasi->save($pdfDokumentasiPath);
            $dokumenExists = true;
        }

        // 5. PDF (Monitoring)
        $pdfMonitoring = FacadePdf::loadView('contents.pdf.ketercapaianMonitoring', array_merge($data, ['pieChartImage' => $pieChartImagePath]));
        $pdfMonitoringPath = $tempDir . '/monitoring.pdf';
        $pdfMonitoring->save($pdfMonitoringPath);

        // Merge PDFs
        $pdf = new Fpdi();

        // 1. Add Blueprint PDF
        $pageCount = $pdf->setSourceFile($pdfBlueprintPath);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $pdf->addPage();
            $pdf->useTemplate($templateId);
        }

        // 2. Add Rubrik PDF
        $pageCount = $pdf->setSourceFile($pdfRubrikPath);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $pdf->addPage();
            $pdf->useTemplate($templateId);
        }

        // 3. Add Uploaded PDF (Jika Ada)
        if ($uploadedFileExists && isset($uploadedFilePathTemp)) {
            $pageCount = $pdf->setSourceFile($uploadedFilePathTemp);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);

                // Orientation
                $pdf->addPage($size['width'] > $size['height'] ? 'L' : 'P', [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);
            }
        }

        // 4. Add Dokumentasi PDF (Jika Ada)
        if ($dokumenExists && isset($pdfDokumentasiPath)) {
            $pageCount = $pdf->setSourceFile($pdfDokumentasiPath);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
        }

        // 5. Add Monitoring PDF
        $pageCount = $pdf->setSourceFile($pdfMonitoringPath);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $pdf->addPage();
            $pdf->useTemplate($templateId);
        }

        $fileName = 'KetercapaianTujuan_' . date('Y_m_d_H_i_s') . '.pdf';
        $outputPath = $tempDir . '/' . $fileName;
        $pdf->Output($outputPath, 'F');

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}

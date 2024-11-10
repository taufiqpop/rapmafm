<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\Blueprint;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ImplementasiController extends Controller
{
    // List Sekolah
    public function index()
    {
        $user = Auth::user();
        $sekolah = Sekolah::where('user_id', $user->id)->get();
        $blueprint = Blueprint::with('sekolah')->get();
        $dokumentasi = Dokumentasi::with('sekolah')->get();

        $data = [
            'title' => 'Implementasi Teknik Penilaian',
            'sekolah' => $sekolah,
            'blueprint' => $blueprint,
            'dokumentasi' => $dokumentasi,
        ];

        return view('contents.implementasi.list', $data);
    }

    public function data(Request $request)
    {
        $user_id = Auth::id();
        $list = Sekolah::select('sekolah.*', DB::raw('IF(dokumentasi.id IS NULL, 0, 1) as dokumentasi_exists'))
            ->leftJoin('dokumentasi', function ($join) {
                $join->on('dokumentasi.sekolah_id', '=', 'sekolah.id')
                    ->whereNull('dokumentasi.deleted_at');
            })
            ->with(['materi_pelajaran.materi_matpel'])
            ->where('sekolah.user_id', $user_id)
            ->where('sekolah.is_archived', 0)
            ->groupBy('sekolah.id');

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('materi_pelajaran', function ($row) {
                return $row->materi_pelajaran->map(function ($item) {
                    return $item->materi_matpel->nama_materi;
                })->implode(', ');
            })
            ->make();
    }

    // Load Halaman
    public function load_halaman(Request $request)
    {
        $halaman = $request->halaman;
        $html = view("contents.implementasi.halaman.{$halaman}", [
            'sekolah_id' => $request->sekolah_id,
        ])->render();

        return response()->json([
            'status' => true,
            'html' => $html
        ]);
    }

    // Upload Soal
    public function uploadSoal(Request $request)
    {
        $request->validate([
            'file_soal' => 'required|mimes:pdf|max:2048',
            'id' => 'required|exists:sekolah,id'
        ]);

        try {
            $sekolah = Sekolah::findOrFail($request->id);

            if ($sekolah->file_soal) {
                $existingFilePath = storage_path('app/public/' . $sekolah->file_soal);
                if (file_exists($existingFilePath)) {
                    Storage::disk('public')->delete($sekolah->file_soal);
                }
            }

            if ($request->hasFile('file_soal')) {
                $file_soal = $request->file('file_soal');
                $filename = Str::slug($sekolah->nama) . '-' . time() . '.' . $file_soal->getClientOriginalExtension();
                $path = $file_soal->storeAs('uploads/documents/soal', $filename, 'public');
                $sekolah->file_soal = $path;

                if ($sekolah->isDirty()) {
                    $sekolah->save();
                }
            }

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Delete Soal
    public function deleteSoal($id)
    {
        try {
            $sekolah = Sekolah::findOrFail($id);

            if ($sekolah->file_soal) {
                $filePath = $sekolah->file_soal;
                $fullPath = storage_path('app/public/' . $filePath);

                if (file_exists($fullPath)) {
                    Storage::disk('public')->delete($filePath);
                    $sekolah->file_soal = null;
                    $sekolah->save();

                    return response()->json(['status' => true, 'msg' => 'Data Berhasil Dihapus!'], 200);
                } else {
                    $sekolah->file_soal = null;
                    $sekolah->save();

                    return response()->json(['status' => true, 'msg' => 'File tidak ditemukan, namun data telah dihapus dari database!'], 200);
                }
            }

            return response()->json(['status' => false, 'msg' => 'Data Tidak Ditemukan!'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => 'Gagal Menghapus Data : ' . $e->getMessage()], 400);
        }
    }

    // Data Dokumentasi
    public function dataDokumentasi(Request $request)
    {
        $sekolah_id = $request->input('sekolah_id');
        $list = Dokumentasi::select(DB::raw('*'))->where('sekolah_id', $sekolah_id)->where('deleted_at', null);

        return DataTables::of($list)
            ->addIndexColumn()
            ->make();
    }

    // Upload Dokumentasi
    public function uploadDokumentasi(Request $request)
    {
        try {
            $request->validate([
                'dokumen.*' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ]);

            if (!$request->hasFile('dokumen')) {
                return back()->withErrors(['dokumen' => 'No files were uploaded.']);
            }

            foreach ($request->file('dokumen') as $file) {
                $path = $file->store('uploads/documents/dokumentasi', 'public');

                Dokumentasi::create([
                    'sekolah_id' => $request->sekolah_id,
                    'nama_file' => $file->getClientOriginalName(),
                    'path_file' => $path,
                    'size' => $file->getSize(),
                ]);
            }

            return back()->with('success', 'Files uploaded successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while uploading the files: ' . $e->getMessage()]);
        }
    }

    // Delete Dokumentasi
    public function deleteDokumentasi(Request $request)
    {
        try {
            $deleteDokumen = Dokumentasi::find($request->id);

            if (!$deleteDokumen) {
                return response()->json(['status' => false, 'msg' => 'Dokumen tidak ditemukan.'], 404);
            }

            $filePath = $deleteDokumen->path_file;
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $deleteDokumen->delete();
            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Download Excel
    public function downloadExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);

        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'NAMA');
        $sheet->setCellValue('C1', 'SKOR KOGNITIF');
        $sheet->setCellValue('D1', 'SKOR AFEKTIF');
        $sheet->setCellValue('E1', 'SKOR PSIKOMOTORIK');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        $sheet->getStyle('A:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A:E')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A1:E2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $fileName = 'TemplateExcel_' . date('Y_m_d_H_i_s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    // Import Excel
    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
            'id' => 'required|exists:sekolah,id'
        ]);

        try {
            $sekolah = Sekolah::findOrFail($request->id);
            $blueprints = Blueprint::where('sekolah_id', $sekolah->id)->get();
            $KG = $blueprints[0]->bobot_penilaian / 100;
            $AF = $blueprints[1]->bobot_penilaian / 100;
            $PS = $blueprints[2]->bobot_penilaian / 100;

            if ($sekolah->file_excel) {
                $existingFilePath = storage_path('app/public/' . $sekolah->file_excel);
                if (file_exists($existingFilePath)) {
                    Storage::disk('public')->delete($sekolah->file_excel);
                }
            }

            if ($request->hasFile('file_excel')) {
                $file_excel = $request->file('file_excel');
                $filename = Str::slug($sekolah->nama) . '-' . time() . '.' . $file_excel->getClientOriginalExtension();
                $path = $file_excel->storeAs('uploads/documents/penilaian', $filename, 'public');
                $sekolah->file_excel = $path;

                if ($sekolah->isDirty()) {
                    $sekolah->save();
                }

                $spreadsheet = IOFactory::load($file_excel->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                $processedData = [];
                $processed = 0;
                $totalScore = 0;
                $scores = [];

                foreach (array_slice($rows, 1) as $row) {
                    if (isset($row[1]) && isset($row[2]) && isset($row[3]) && isset($row[4])) {
                        $skorAkhir = ($row[2] * $KG) + ($row[3] *  $AF) + ($row[4] * $PS);

                        Siswa::create([
                            'nama'                => $row[1],
                            'skor_kognitif'       => $row[2] ?? 0,
                            'skor_afektif'        => $row[3] ?? 0,
                            'skor_psikomotorik'   => $row[4] ?? 0,
                            'skor_akhir'          => $skorAkhir,
                            'sekolah_id'          => $sekolah->id,
                        ]);

                        $processed++;
                        $totalScore += $skorAkhir;
                        $scores[] = $skorAkhir;

                        $processedData[] = [
                            'nama'                => $row[1],
                            'skor_kognitif'       => $row[2] ?? 0,
                            'skor_afektif'        => $row[3] ?? 0,
                            'skor_psikomotorik'   => $row[4] ?? 0,
                        ];
                    }
                }

                $jumlah_siswa = $processed;
                $minimal = !empty($scores) ? min($scores) : 0;
                $maksimal = !empty($scores) ? max($scores) : 0;
                $mean = $jumlah_siswa > 0 ? $totalScore / $jumlah_siswa : 0;

                $sekolah->jumlah_siswa = $jumlah_siswa;
                $sekolah->minimal = $minimal;
                $sekolah->maksimal = $maksimal;
                $sekolah->mean = $mean;
                $sekolah->save();

                if ($processed > 0) {
                    return response()->json([
                        'status' => true,
                        'file_path' => $path,
                        'processed' => $processed,
                        'data' => $processedData,
                        'jumlah_siswa' => $jumlah_siswa,
                        'minimal' => $minimal,
                        'maksimal' => $maksimal,
                        'mean' => $mean
                    ], 200);
                } else {
                    return response()->json(['status' => false, 'msg' => 'No valid data found to process.'], 400);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => 'Error processing file: ' . $e->getMessage()], 400);
        }
    }

    // Delete Excel
    public function deleteExcel($id)
    {
        try {
            $sekolah = Sekolah::findOrFail($id);

            if ($sekolah->file_excel) {
                $filePath = $sekolah->file_excel;
                $fullPath = storage_path('app/public/' . $filePath);

                if (file_exists($fullPath)) {
                    Storage::disk('public')->delete($filePath);
                    $sekolah->file_excel = null;
                    $sekolah->jumlah_siswa = null;
                    $sekolah->minimal = null;
                    $sekolah->maksimal = null;
                    $sekolah->mean = null;
                    $sekolah->save();

                    Siswa::where('sekolah_id', $sekolah->id)->delete();
                    return response()->json(['status' => true, 'msg' => 'Data Berhasil Dihapus!'], 200);
                }

                return response()->json(['status' => false, 'msg' => 'Data Tidak Ditemukan!'], 404);
            }

            return response()->json(['status' => false, 'msg' => 'Data Tidak Ditemukan!'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => 'Gagal Menghapus Data : ' . $e->getMessage()], 400);
        }
    }

    // Fetch Excel
    public function fetchExcelContent(Request $request)
    {
        try {
            $file_excel = $request->input('file_excel');
            $filePath = storage_path('app/public/' . $file_excel);

            if (!file_exists($filePath)) {
                return response()->json(['status' => false, 'msg' => 'Data Tidak Ditemukan.'], 404);
            }

            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

            return response()->json(['status' => true, 'data' => $data], 200);
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            return response()->json(['status' => false, 'msg' => 'Error reading Excel file: ' . $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => 'An error occurred: ' . $e->getMessage()], 400);
        }
    }

    // Preview Penilaian
    public function previewPenilaian(Request $request)
    {
        $studentId = $request->input('student_id');
        $studentData = Siswa::where('sekolah_id', $studentId)->get();

        if ($studentData->isEmpty()) {
            return response()->json(['status' => false, 'msg' => 'Siswa Tidak Ditemukan!'], 404);
        }

        $blueprints = Blueprint::where('sekolah_id', $studentId)->get();

        $kognitifWeight = $afektifGuruWeight = $afektifPesdikWeight = 0;

        foreach ($blueprints as $blueprint) {
            if ($blueprint->ranah_penilaian == 'Kognitif') {
                $kognitifWeight = $blueprint->bobot_penilaian;
            } elseif ($blueprint->ranah_penilaian == 'Afektif') {
                $afektifGuruWeight = $blueprint->bobot_penilaian;
            } elseif ($blueprint->ranah_penilaian == 'Psikomotorik') {
                $afektifPesdikWeight = $blueprint->bobot_penilaian;
            }
        }

        $responseData = [];

        foreach ($studentData as $student) {
            $kognitif = $student->skor_kognitif;
            $afektifGuru = $student->skor_afektif;
            $afektifPesdik = $student->skor_psikomotorik;

            $finalScore = (($kognitif * $kognitifWeight) + ($afektifGuru * $afektifGuruWeight) + ($afektifPesdik * $afektifPesdikWeight)) / 100;

            $responseData[] = [
                'nama' => $student->nama,
                'skor_kognitif' => $kognitif,
                'skor_afektif' => $afektifGuru,
                'skor_psikomotorik' => $afektifPesdik,
                'final_score' => $finalScore,
            ];
        }

        return response()->json([
            'status' => true,
            'data' => $responseData
        ]);
    }

    // Download Penilaian
    public function downloadPenilaian($id)
    {
        $students = Siswa::where('sekolah_id', $id)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);

        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'NAMA');
        $sheet->setCellValue('C1', 'SKOR KOGNITIF');
        $sheet->setCellValue('D1', 'SKOR AFEKTIF');
        $sheet->setCellValue('E1', 'SKOR PSIKOMOTORIK');
        $sheet->setCellValue('F1', 'SKOR AKHIR');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A:F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A:F')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:F1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');

        $row = 2;
        foreach ($students as $index => $student) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $student->nama);
            $sheet->setCellValue('C' . $row, $student->skor_kognitif);
            $sheet->setCellValue('D' . $row, $student->skor_afektif);
            $sheet->setCellValue('E' . $row, $student->skor_psikomotorik);
            $sheet->setCellValue('F' . $row, $student->skor_akhir);

            $sheet->getStyle('A' . $row . ':F' . $row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $sheet->getStyle('F' . $row)
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFF00');

            $sheet->getStyle('F' . $row)
                ->getFont()
                ->setBold(true);

            $row++;
        }

        $fileName = 'HasilAkhirPenilaian_' . date('Y_m_d_H_i_s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }
}

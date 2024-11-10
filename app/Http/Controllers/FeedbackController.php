<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Sekolah;
use App\Models\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class FeedbackController extends Controller
{
    // List Sekolah
    public function index()
    {
        $user = Auth::user();
        $sekolah = Sekolah::where('user_id', $user->id)->get();
        $blueprint = Blueprint::with('sekolah')->get();

        $data = [
            'title' => 'Feedback',
            'sekolah' => $sekolah,
            'blueprint' => $blueprint,
        ];

        return view('contents.feedback.list', $data);
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

    // List Siswa
    public function edit($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $sekolah = Sekolah::where('id', $id)->firstOrFail();
        $data  = [
            'title' => 'Edit Feedback',
            'sekolah' => $sekolah,
        ];

        return view('contents.feedback.form', $data);
    }

    public function form(Request $request)
    {
        $sekolah_id = $request->input('sekolah_id');
        $list = Siswa::select(DB::raw('*'))->where('sekolah_id', $sekolah_id);

        return DataTables::of($list)
            ->addIndexColumn()
            ->make();
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

    // Download Feedback (Excel)
    public function downloadFeedback($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $siswa = Siswa::where('sekolah_id', $id)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(40);

        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'NAMA');
        $sheet->setCellValue('C1', 'SKOR KOGNITIF');
        $sheet->setCellValue('D1', 'SKOR AFEKTIF');
        $sheet->setCellValue('E1', 'SKOR PSIKOMOTORIK');
        $sheet->setCellValue('F1', 'SKOR AKHIR');
        $sheet->setCellValue('G1', 'FEEDBACK');

        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A:G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A:G')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:G1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');

        $row = 2;
        foreach ($siswa as $index => $student) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $student->nama);
            $sheet->setCellValue('C' . $row, $student->skor_kognitif);
            $sheet->setCellValue('D' . $row, $student->skor_afektif);
            $sheet->setCellValue('E' . $row, $student->skor_psikomotorik);
            $sheet->setCellValue('F' . $row, $student->skor_akhir);
            $sheet->setCellValue('G' . $row, $student->feedback);

            $sheet->getStyle('A' . $row . ':G' . $row)
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

        $fileName = 'FeedbackPenilaian_' . date('Y_m_d_H_i_s') . '.xlsx';
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

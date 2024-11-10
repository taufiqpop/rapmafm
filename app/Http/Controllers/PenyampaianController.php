<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PenyampaianController extends Controller
{
    // List Sekolah
    public function index()
    {
        $user = Auth::user();
        $sekolah = Sekolah::where('user_id', $user->id)->get();
        $blueprint = Blueprint::with('sekolah')->get();

        $data = [
            'title' => 'Penyampaian Tujuan & Kriteria Sukses',
            'sekolah' => $sekolah,
            'blueprint' => $blueprint,
        ];

        return view('contents.penyampaian.list', $data);
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
}

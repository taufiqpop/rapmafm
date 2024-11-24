<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AlumniController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Alumni'
        ];

        return view('contents.members.alumni.list', $data);
    }

    public function data(Request $request)
    {
        $list = Alumni::select(DB::raw('*'));

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
            'fullname' => 'required|string',
            'nickname' => 'required|string',
            'gender' => 'required|string',
            'divisi' => 'required|string',
            'sub_divisi' => 'required|string',
            'no_hp' => 'nullable|integer',
            'fakultas' => 'required|string',
            'prodi' => 'required|string',
            'tahun_kepengurusan' => 'required|integer',
            'instagram' => 'required|string',
        ]);

        try {
            $data = [
                'fullname' => $request->fullname,
                'nickname' => $request->nickname,
                'gender' => $request->gender,
                'divisi' => $request->divisi,
                'sub_divisi' => $request->sub_divisi,
                'no_hp' => $request->no_hp,
                'fakultas' => $request->fakultas,
                'prodi' => $request->prodi,
                'tahun_kepengurusan' => $request->tahun_kepengurusan,
                'instagram' => $request->instagram,
            ];

            Alumni::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string',
            'nickname' => 'required|string',
            'gender' => 'required|string',
            'divisi' => 'required|string',
            'sub_divisi' => 'required|string',
            'no_hp' => 'nullable|integer',
            'fakultas' => 'required|string',
            'prodi' => 'required|string',
            'tahun_kepengurusan' => 'required|integer',
            'instagram' => 'required|string',
        ]);

        try {
            $alumni = Alumni::find($request->id);
            $alumni->fullname = $request->fullname;
            $alumni->nickname = $request->nickname;
            $alumni->gender = $request->gender;
            $alumni->divisi = $request->divisi;
            $alumni->sub_divisi = $request->sub_divisi;
            $alumni->no_hp = $request->no_hp;
            $alumni->fakultas = $request->fakultas;
            $alumni->prodi = $request->prodi;
            $alumni->tahun_kepengurusan = $request->tahun_kepengurusan;
            $alumni->instagram = $request->instagram;

            if ($alumni->isDirty()) {
                $alumni->save();
            }

            if ($alumni->wasChanged()) {
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
            $alumni = Alumni::find($request->id);
            $alumni->delete();

            if ($alumni->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }


    // Switch Status
    public function switchStatus(Request $request)
    {
        try {
            $alumni = Alumni::find($request->id);
            $alumni->is_active = $request->value;

            if ($alumni->isDirty()) {
                $alumni->save();
            }

            if ($alumni->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Export Excel
    public function exportExcel()
    {
        $alumni = Alumni::orderBy('tahun_kepengurusan', 'asc')->orderBy('fullname', 'asc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Lengkap');
        $sheet->setCellValue('C1', 'Nama Panggilan');
        $sheet->setCellValue('D1', 'Jenis Kelamin');
        $sheet->setCellValue('E1', 'Divisi');
        $sheet->setCellValue('F1', 'Sub Divisi');
        $sheet->setCellValue('G1', 'Tahun Kepengurusan');
        $sheet->setCellValue('H1', 'No HP');
        $sheet->setCellValue('I1', 'Fakultas');
        $sheet->setCellValue('J1', 'Program Studi');
        $sheet->setCellValue('K1', 'Instagram');

        $headerStyle = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:K1')->applyFromArray($headerStyle);

        $sheet->getRowDimension(1)->setRowHeight(20);

        $row = 2;
        foreach ($alumni as $data) {
            $sheet->setCellValue('A' . $row, $row - 1);
            $sheet->setCellValue('B' . $row, $data->fullname);
            $sheet->setCellValue('C' . $row, $data->nickname);
            $sheet->setCellValue('D' . $row, $data->gender == 'L' ? 'Laki-Laki' : 'Perempuan');
            $sheet->setCellValue('E' . $row, $data->divisi);
            $sheet->setCellValue('F' . $row, $data->sub_divisi);
            $sheet->setCellValue('G' . $row, $data->tahun_kepengurusan);
            $sheet->setCellValue('H' . $row, $data->no_hp ?? '');
            $sheet->setCellValue('I' . $row, $data->fakultas);
            $sheet->setCellValue('J' . $row, $data->prodi);
            $sheet->setCellValue('K' . $row, '@' . $data->instagram);
            $row++;
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:K' . ($row - 1))->applyFromArray($styleArray);

        $contentStyle = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];
        $sheet->getStyle('B2:F' . ($row - 1))->applyFromArray($contentStyle);
        $sheet->getStyle('J2:K' . ($row - 1))->applyFromArray($contentStyle);

        $numberStyle = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle('A2:A' . ($row - 1))->applyFromArray($numberStyle);
        $sheet->getStyle('G2:I' . ($row - 1))->applyFromArray($numberStyle);

        foreach (range('A', 'K') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'data-alumni-rapmafm.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}

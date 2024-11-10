<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MonitoringController extends Controller
{
    // List Monitoring
    public function index()
    {
        $user = Auth::user();
        $sekolah = Sekolah::where('user_id', $user->id)->get();

        $data = [
            'title' => 'Monitoring Peserta Didik',
            'sekolah' => $sekolah,
        ];

        return view('contents.monitoring.list', $data);
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

    // Edit Monitoring
    public function edit($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $sekolah = Sekolah::findOrFail($id);
        $siswa = Siswa::where('sekolah_id', $id)->get();

        $pieChartData = [
            'dibawah60' => $siswa->filter(function ($item) {
                return $item->skor_akhir < 60;
            })->count(),
            'antara6070' => $siswa->filter(function ($item) {
                return $item->skor_akhir >= 61 && $item->skor_akhir <= 70;
            })->count(),
            'antara7080' => $siswa->filter(function ($item) {
                return $item->skor_akhir >= 71 && $item->skor_akhir <= 80;
            })->count(),
            'antara8090' => $siswa->filter(function ($item) {
                return $item->skor_akhir >= 81 && $item->skor_akhir <= 90;
            })->count(),
            'diatas90' => $siswa->filter(function ($item) {
                return $item->skor_akhir > 90;
            })->count(),
        ];

        $data = [
            'title' => 'Monitoring Peserta Didik',
            'sekolah' => $sekolah,
            'pieChartData' => $pieChartData,
        ];

        return view('contents.monitoring.form', $data);
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

    // Download Monitoring
    public function downloadMonitoring($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $students = Siswa::where('sekolah_id', $id)->get();

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
        $scores = [];

        $countRange = [
            '<60' => 0,
            '61-70' => 0,
            '71-80' => 0,
            '81-90' => 0,
            '>90' => 0,
        ];

        foreach ($students as $index => $student) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $student->nama);
            $sheet->setCellValue('C' . $row, $student->skor_kognitif);
            $sheet->setCellValue('D' . $row, $student->skor_afektif);
            $sheet->setCellValue('E' . $row, $student->skor_psikomotorik);
            $sheet->setCellValue('F' . $row, $student->skor_akhir);
            $sheet->setCellValue('G' . $row, $student->feedback);
            $sheet->getStyle('A' . $row . ':G' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle('F' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
            $sheet->getStyle('F' . $row)->getFont()->setBold(true);

            if ($student->skor_akhir < 60) {
                $countRange['<60']++;
            } elseif ($student->skor_akhir <= 70) {
                $countRange['61-70']++;
            } elseif ($student->skor_akhir <= 80) {
                $countRange['71-80']++;
            } elseif ($student->skor_akhir <= 90) {
                $countRange['81-90']++;
            } else {
                $countRange['>90']++;
            }

            $scores[] = $student->skor_akhir;
            $row++;
        }

        $row++;

        $n = count($scores);
        $min = min($scores);
        $max = max($scores);
        $mean = $n > 0 ? array_sum($scores) / $n : 0;

        $sheet->setCellValue('A' . $row, 'N');
        $sheet->setCellValue('B' . $row, $n);
        $sheet->getStyle('A' . $row . ':B' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $row++;
        $sheet->setCellValue('A' . $row, 'Min');
        $sheet->setCellValue('B' . $row, $min);
        $sheet->getStyle('A' . $row . ':B' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $row++;
        $sheet->setCellValue('A' . $row, 'Max');
        $sheet->setCellValue('B' . $row, $max);
        $sheet->getStyle('A' . $row . ':B' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $row++;
        $sheet->setCellValue('A' . $row, 'Mean');
        $sheet->setCellValue('B' . $row, $mean);
        $sheet->getStyle('A' . $row . ':B' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $row++;

        $row++;
        $sheet->setCellValue('A' . $row, '<60');
        $sheet->setCellValue('B' . $row, $countRange['<60']);
        $sheet->getStyle('A' . $row . ':B' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $row++;
        $sheet->setCellValue('A' . $row, '61-70');
        $sheet->setCellValue('B' . $row, $countRange['61-70']);
        $sheet->getStyle('A' . $row . ':B' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $row++;
        $sheet->setCellValue('A' . $row, '71-80');
        $sheet->setCellValue('B' . $row, $countRange['71-80']);
        $sheet->getStyle('A' . $row . ':B' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $row++;
        $sheet->setCellValue('A' . $row, '81-90');
        $sheet->setCellValue('B' . $row, $countRange['81-90']);
        $sheet->getStyle('A' . $row . ':B' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $row++;
        $sheet->setCellValue('A' . $row, '>90');
        $sheet->setCellValue('B' . $row, $countRange['>90']);
        $sheet->getStyle('A' . $row . ':B' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $dataSeriesLabels = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$' . ($row - 4), null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$' . ($row - 3), null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$' . ($row - 2), null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$' . ($row - 1), null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$' . $row, null, 1),
        ];

        $xAxisTickValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$' . ($row - 4) . ':$A$' . $row, null, 5),
        ];

        $dataSeriesValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$B$' . ($row - 4) . ':$B$' . $row, null, 5),
        ];

        $series = new DataSeries(
            DataSeries::TYPE_PIECHART,
            null,
            range(0, count($dataSeriesValues) - 1),
            $dataSeriesLabels,
            $xAxisTickValues,
            $dataSeriesValues
        );

        $layout = new Layout();
        $layout->setShowVal(true);
        $layout->setShowPercent(true);

        $plotArea = new PlotArea($layout, [$series]);
        $legend = new Legend(Legend::POSITION_RIGHT, null, false);

        $title = new Title('Distribusi Skor Akhir');

        $chart = new Chart(
            'score_distribution',
            $title,
            $legend,
            $plotArea,
            true,
            0,
            null,
            null
        );

        $chart->setTopLeftPosition('D' . ($row - 7));
        $chart->setBottomRightPosition('F' . ($row + 10));

        $fileName = 'HasilAkhirMonitoring_' . date('Y_m_d_H_i_s') . '.xlsx';
        $sheet->addChart($chart);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->setIncludeCharts(true);
        $writer->save('php://output');
    }
}

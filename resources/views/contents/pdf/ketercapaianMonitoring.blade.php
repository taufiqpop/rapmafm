<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Peserta Didik</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        .header {
            text-align: center;
            font-weight: bold;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
        }

        .no-border {
            border: none !important;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h2 class="header">Monitoring Peserta Didik</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Skor Kognitif</th>
                <th>Skor Afektif</th>
                <th>Skor Psikomotorik</th>
                <th>Skor Akhir</th>
                <th>Feedback</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $index => $items)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $items->nama }}</td>
                    <td>{{ $items->skor_kognitif }}</td>
                    <td>{{ $items->skor_afektif }}</td>
                    <td>{{ $items->skor_psikomotorik }}</td>
                    <td>{{ $items->skor_akhir }}</td>
                    <td style="text-align: justify">{{ $items->feedback }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th>N</th>
                <th>Minimum</th>
                <th>Maximum</th>
                <th>MEAN</th>
                <th>Hasil Monitoring Peserta Didik</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $sekolah->jumlah_siswa }}</td>
                <td>{{ $sekolah->minimal }}</td>
                <td>{{ $sekolah->maksimal }}</td>
                <td>{{ $sekolah->mean }}</td>
                <td style="text-align: justify">{{ $sekolah->hasil_monitoring }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th>Komentar Guru Atas Ketercapaian Pembelajaran</th>
                <th>Strategi Pembelajaran Yang Akan Datang</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <textarea
                        style="width: auto; height: auto; font-family: 'Times New Roman', Times, serif; padding: 10px; text-align: left; border: none; vertical-align: top">{{ $sekolah->komentar_guru }}</textarea>
                </td>
                <td>
                    <textarea
                        style="width: auto; height: auto; font-family: 'Times New Roman', Times, serif; padding: 10px; text-align: left; border: none; vertical-align: top">{{ $sekolah->strategi_pembelajaran }}</textarea>
                </td>
            </tr>
        </tbody>
    </table>

    <center>
        <div>
            <div style="display: inline-block; vertical-align: top;">
                <img src="{{ $pieChartImage }}" alt="Pie Chart" />
            </div>
            <div style="display: inline-block; vertical-align: top; margin-left: 20px;">
                <table style="margin-top: 20px; border-collapse: collapse;">
                    <tr>
                        <td style="width: 20px; height: 20px; background-color: red;"></td>
                        <td>&lt; 60</td>
                    </tr>
                    <tr>
                        <td style="width: 20px; height: 20px; background-color: orange;"></td>
                        <td>60 - 70</td>
                    </tr>
                    <tr>
                        <td style="width: 20px; height: 20px; background-color: yellow;"></td>
                        <td>71 - 80</td>
                    </tr>
                    <tr>
                        <td style="width: 20px; height: 20px; background-color: blue;"></td>
                        <td>81 - 90</td>
                    </tr>
                    <tr>
                        <td style="width: 20px; height: 20px; background-color: rgb(0, 255, 0);"></td>
                        <td>91 - 100</td>
                    </tr>
                </table>
            </div>
        </div>
    </center>

    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
        $formattedDate = Carbon::parse($sekolah->updated_at)->translatedFormat('d F Y');
    @endphp

    <div style="margin-top: 30px;">
        <table class="no-border">
            <tr>
                <td class="no-border text-right">
                    Surakarta, {{ $formattedDate }}
                </td>
            </tr>
        </table>
        <div style="margin-top: 75px;">
            <table class="no-border">
                <tr>
                    <td class="no-border text-right">
                        ({{ $sekolah->nama_guru }})
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>

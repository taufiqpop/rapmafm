<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Rubrik untuk AFEL</title>
</head>

<body style="font-family: 'Times New Roman', Times, serif; font-size: 12pt;">
    <h2 style="text-align: center;">Form Rubrik untuk AFEL</h2>

    <table border="0.5" cellpadding="5" cellspacing="0" style="width: 100%; margin: auto; border-color: #000000;">
        <tr>
            <td>Nama Sekolah</td>
            <td style="text-align: center;"> : </td>
            <td>{{ $sekolah->nama }}</td>
        </tr>
        <tr>
            <td>Tahun Ajaran</td>
            <td style="text-align: center;"> : </td>
            <td>{{ $sekolah->tahun }}</td>
        </tr>
        <tr>
            <td>Mata Pelajaran</td>
            <td style="text-align: center;"> : </td>
            <td>{{ $sekolah->matpel }}</td>
        </tr>
        <tr>
            <td>Materi Pelajaran</td>
            <td style="text-align: center;"> : </td>
            <td>
                @foreach ($materiPelajaran as $index => $materi_pelajaran)
                    {{ $index + 1 }}. {{ $materi_pelajaran->materi_matpel->nama_materi }}<br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td>Semester</td>
            <td style="text-align: center;"> : </td>
            <td>{{ $sekolah->semester }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td style="text-align: center;"> : </td>
            <td>{{ $sekolah->kelas }} ({{ $sekolah->kode_kelas }})</td>
        </tr>
        <tr>
            <td>Nama Guru</td>
            <td style="text-align: center;"> : </td>
            <td>{{ $sekolah->nama_guru }}</td>
        </tr>
    </table>

    <div style="margin-top: 30px;">
        @foreach ($blueprints as $blueprint)
            <h3>{{ $blueprint->ranah_penilaian }}</h3>
            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin: auto;">
                <tr>
                    <th>Ranah Penilaian</th>
                    <th>Bobot Ranah Penilaian</th>
                    <th>Bentuk Penilaian</th>
                    <th>Bentuk</th>
                </tr>
                <tr>
                    <td style="text-align: center;">{{ $blueprint->ranah_penilaian }}</td>
                    <td style="text-align: center;">{{ $blueprint->bobot_penilaian }} %</td>
                    <td style="text-align: center;">{{ $blueprint->instrumen_penilaian }}</td>
                    <td style="text-align: center;">
                        {{ $blueprint->bentuk === 'Lainnya' ? $blueprint->bentuk_lainnya : $blueprint->bentuk }}
                    </td>
                </tr>
            </table>

            <div style="margin-top: 30px;">
                @if ($blueprint->ranah_penilaian == 'Kognitif')
                    @include('contents.pdf.partials.rubrik.kognitif', [
                        'materiBlueprints' => $materiBlueprints,
                    ])
                @elseif ($blueprint->ranah_penilaian == 'Afektif')
                    @include('contents.pdf.partials.rubrik.afektif', [
                        'materiBlueprints' => $materiBlueprints,
                    ])
                @elseif ($blueprint->ranah_penilaian == 'Psikomotorik')
                    @include('contents.pdf.partials.rubrik.psikomotorik', [
                        'materiBlueprints' => $materiBlueprints,
                    ])
                @endif
            </div>
        @endforeach
    </div>
</body>

</html>

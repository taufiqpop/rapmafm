<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blueprints->ranah_penilaian }} - Form Kisi-Kisi untuk AFEL</title>
</head>

<body style="font-family: 'Times New Roman', Times, serif; font-size: 12pt;">
    <h2 style="text-align: center;">Form Kisi-Kisi untuk AFEL {{ $blueprints->ranah_penilaian }}</h2>

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
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin: auto;">
            <tr>
                <th>Ranah Penilaian</th>
                <th>Bobot Ranah Penilaian</th>
                <th>Bentuk Penilaian</th>
                <th>Bentuk</th>
            </tr>
            <tr>
                <td style="text-align: center;">{{ $blueprints->ranah_penilaian }}</td>
                <td style="text-align: center;">{{ $blueprints->bobot_penilaian }} %</td>
                <td style="text-align: center;">{{ $blueprints->instrumen_penilaian }}</td>
                <td style="text-align: center;">
                    {{ $blueprints->bentuk === 'Lainnya' ? $blueprints->bentuk_lainnya : $blueprints->bentuk }}
                </td>
            </tr>
        </table>

        <div style="margin-top: 30px;">

            {{-- Konten Download Kognitif --}}
            @if ($blueprints->ranah_penilaian == 'Kognitif')
                <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin: auto;">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Materi</th>
                            <th rowspan="2">Indikator Pembelajaran</th>
                            <th colspan="7">Ranah Kognitif</th>
                        </tr>
                        <tr>
                            <th>Remember</th>
                            <th>Understand</th>
                            <th>Apply</th>
                            <th>Analyze</th>
                            <th>Evaluate</th>
                            <th>Create</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materiBlueprints as $index => $materiBlueprint)
                            @php
                                $target_pengetahuan_count = count($materiBlueprint->indikator);
                            @endphp
                            @foreach ($materiBlueprint->indikator as $key => $indikator)
                                <tr>
                                    @if ($key === 0)
                                        <td rowspan="{{ $target_pengetahuan_count }}">{{ $index + 1 }}</td>
                                        <td rowspan="{{ $target_pengetahuan_count }}">
                                            {{ $materiBlueprint->materi }}</td>
                                    @endif
                                    <td>{{ $indikator->target_pengetahuan }}</td>
                                    <td style="text-align: center;">{{ $indikator->rk_remember }}</td>
                                    <td style="text-align: center;">{{ $indikator->rk_understand }}</td>
                                    <td style="text-align: center;">{{ $indikator->rk_apply }}</td>
                                    <td style="text-align: center;">{{ $indikator->rk_analyze }}</td>
                                    <td style="text-align: center;">{{ $indikator->rk_evaluate }}</td>
                                    <td style="text-align: center;">{{ $indikator->rk_create }}</td>
                                    <td style="text-align: center;">{{ $indikator->total_kognitif }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>

                {{-- Konten Download Afektif --}}
            @elseif ($blueprints->ranah_penilaian == 'Afektif')
                <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin: auto;">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Nama Siswa</th>
                            <th colspan="6">Ranah Afektif</th>
                        </tr>
                        <tr>
                            <th>Receiving</th>
                            <th>Responding</th>
                            <th>Valuing</th>
                            <th>Organization</th>
                            <th>Characterization</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materiBlueprints as $index => $materiBlueprint)
                            @foreach ($materiBlueprint->indikator as $key => $indikator)
                                <tr>
                                    @if ($key === 0)
                                        <td rowspan="{{ count($materiBlueprint->indikator) }}">
                                            {{ $index + 1 }}</td>
                                        <td rowspan="{{ count($materiBlueprint->indikator) }}">
                                            {{ $materiBlueprint->nama_siswa }}</td>
                                    @endif
                                    <td style="text-align: center;">
                                        @if ($indikator->ra_receiving == 1)
                                            V
                                        @else
                                            X
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($indikator->ra_responding == 1)
                                            V
                                        @else
                                            X
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($indikator->ra_valuing == 1)
                                            V
                                        @else
                                            X
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($indikator->ra_organization == 1)
                                            V
                                        @else
                                            X
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($indikator->ra_characterization == 1)
                                            V
                                        @else
                                            X
                                        @endif
                                    </td>
                                    <td style="text-align: center;">{{ $indikator->total_afektif }}</td>

                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                {{-- Konten Download Psikomotorik --}}
            @elseif ($blueprints->ranah_penilaian == 'Psikomotorik')
                <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin: auto;">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Nama Siswa</th>
                            <th colspan="6">Ranah Afektif</th>
                        </tr>
                        <tr>
                            <th>Receiving</th>
                            <th>Responding</th>
                            <th>Valuing</th>
                            <th>Organization</th>
                            <th>Characterization</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materiBlueprints as $index => $materiBlueprint)
                            @foreach ($materiBlueprint->indikator as $key => $indikator)
                                <tr>
                                    @if ($key === 0)
                                        <td rowspan="{{ count($materiBlueprint->indikator) }}">
                                            {{ $index + 1 }}</td>
                                        <td rowspan="{{ count($materiBlueprint->indikator) }}">
                                            {{ $materiBlueprint->nama_siswa }}</td>
                                    @endif
                                    <td style="text-align: center;">
                                        @if ($indikator->ra_receiving == 1)
                                            V
                                        @else
                                            X
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($indikator->ra_responding == 1)
                                            V
                                        @else
                                            X
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($indikator->ra_valuing == 1)
                                            V
                                        @else
                                            X
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($indikator->ra_organization == 1)
                                            V
                                        @else
                                            X
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($indikator->ra_characterization == 1)
                                            V
                                        @else
                                            X
                                        @endif
                                    </td>
                                    <td style="text-align: center;">{{ $indikator->total_afektif }}</td>

                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @endif

            @php
                use Carbon\Carbon;
                Carbon::setLocale('id');
                $formattedDate = Carbon::parse($sekolah->updated_at)->translatedFormat('d F Y');
            @endphp
            <div style="margin-top: 30px;">
                <table style="border-collapse: collapse; width: 100%;">
                    <tr>
                        <td style="border: none; padding: 5px; text-align: right;">
                            Surakarta, {{ $formattedDate }}
                        </td>
                    </tr>
                </table>
                <div style="margin-top: 75px;">
                    <table style="border-collapse: collapse; width: 100%;">
                        <tr>
                            <td style="border: none; padding: 5px; text-align: right;">{{ $sekolah->nama_guru }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

@if ($blueprints[2]->bobot_penilaian != 0)
    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin: auto;">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Siswa</th>
                <th colspan="6">Ranah Psikomotorik</th>
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
            @php
                $index = 1;
            @endphp
            @foreach ($materiBlueprints as $materiBlueprint)
                @if ($materiBlueprint->blueprint_id == $blueprints[2]->id)
                    @foreach ($materiBlueprint->indikator as $key => $indikator)
                        <tr>
                            <td style="text-align: center">{{ $index++ }}</td>
                            <td>{{ $materiBlueprint->nama_siswa }}</td>
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
                @endif
            @endforeach
        </tbody>
    </table>
@endif

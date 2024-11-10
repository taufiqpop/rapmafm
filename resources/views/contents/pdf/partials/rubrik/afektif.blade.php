@if ($blueprints[1]->bobot_penilaian != 0)
    <table border="1" cellpaddi_rubrik="5" cellspacing="0" style="width: 100%; margin: auto;">
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
            @php
                $index = 1;
            @endphp
            @foreach ($materiBlueprints as $materiBlueprint)
                @if ($materiBlueprint->blueprint_id == $blueprints[1]->id)
                    @foreach ($materiBlueprint->indikator as $key => $indikator)
                        <tr>
                            <td style="text-align: center">{{ $index++ }}</td>
                            <td style="text-align: center">{{ $materiBlueprint->nama_siswa }}</td>
                            <td style="text-align: center;">{{ $indikator->ra_receiving_rubrik }}</td>
                            <td style="text-align: center;">{{ $indikator->ra_responding_rubrik }}</td>
                            <td style="text-align: center;">{{ $indikator->ra_valuing_rubrik }}</td>
                            <td style="text-align: center;">{{ $indikator->ra_organization_rubrik }}</td>
                            <td style="text-align: center;">{{ $indikator->ra_characterization_rubrik }}</td>
                            <td style="text-align: center;">{{ $indikator->total_afektif_rubrik }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
@endif

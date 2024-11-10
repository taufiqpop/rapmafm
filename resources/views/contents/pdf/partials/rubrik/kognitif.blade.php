@if ($blueprints[0]->bobot_penilaian != 0)
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
            @php
                $index = 1;
            @endphp
            @foreach ($materiBlueprints as $materiBlueprint)
                @if ($materiBlueprint->blueprint_id == $blueprints[0]->id)
                    @php
                        $target_pengetahuan_count = count($materiBlueprint->indikator);
                    @endphp
                    @foreach ($materiBlueprint->indikator as $key => $indikator)
                        <tr>
                            @if ($key === 0)
                                <td rowspan="{{ $target_pengetahuan_count }}" style="text-align: center">
                                    {{ $index++ }}
                                </td>
                                <td rowspan="{{ $target_pengetahuan_count }}">
                                    {{ $materiBlueprint->materi }}</td>
                            @endif
                            <td>{{ $indikator->target_pengetahuan }}</td>
                            <td style="text-align: center;">{{ $indikator->rk_remember_rubrik }}</td>
                            <td style="text-align: center;">{{ $indikator->rk_understand_rubrik }}</td>
                            <td style="text-align: center;">{{ $indikator->rk_apply_rubrik }}</td>
                            <td style="text-align: center;">{{ $indikator->rk_analyze_rubrik }}</td>
                            <td style="text-align: center;">{{ $indikator->rk_evaluate_rubrik }}</td>
                            <td style="text-align: center;">{{ $indikator->rk_create_rubrik }}</td>
                            <td style="text-align: center;">{{ $indikator->total_kognitif_rubrik }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
    <div>
        <h3>Kriteria Penilaian :</h3>
        <textarea style="width: 100%; height: auto; font-family: 'Times New Roman', Times, serif; padding: 10px;">{{ $blueprints[0]->kriteria_penilaian }}</textarea>
    </div>
@endif

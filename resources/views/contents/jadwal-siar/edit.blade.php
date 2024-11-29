@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal'];
@endphp

@push('styles')
    <style>
        .table-jadwal-siar {
            border: 3px solid #000;
        }

        .table-jadwal-siar th,
        .table-jadwal-siar td {
            border: 3px solid #000;
        }

        .table-jadwal-siar thead th,
        .table-jadwal-siar thead td {
            border-bottom-width: 1px;
        }

        .form-jadwal-siar {
            display: block;
            width: 100%;
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1.5rem;
            font-weight: bold;
            line-height: 1.5;
            color: #000;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #d1d3e2;
            border-radius: 0.35rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
@endpush

@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Tanggal -->
                <div class="form-group row">
                    <div class="col-sm-2">
                        <input type="date" class="form-jadwal-siar" name="tgl_mulai" value="{{ @$jadwal->tgl_mulai }}"
                            required onchange="update_custom(this)">
                    </div>
                    <label for="tgl_selesai" class="col-form-label">-</label>
                    <div class="col-sm-2">
                        <input type="date" class="form-jadwal-siar" name="tgl_selesai"
                            value="{{ @$jadwal->tgl_selesai }}" required>
                    </div>
                </div>

                {{-- Button Back --}}
                <div class="mb-3">
                    <a href="{{ route('jadwal-siar') }}" class="btn btn-dark"><i class="bx bx-arrow-back"></i>
                        Back</a>
                </div>

                <!-- Table -->
                <div class="row card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-jadwal-siar" width="100%" cellspacing="0">
                                <thead>
                                    <tr style="background-color: antiquewhite; color:black;">
                                        <th class="text-center" style="width: 10%">Program Siar</th>
                                        <th class="text-center">Senin</th>
                                        <th class="text-center">Selasa</th>
                                        <th class="text-center">Rabu</th>
                                        <th class="text-center">Kamis</th>
                                        <th class="text-center">Jum'at</th>
                                        <th class="text-center">Sabtu</th>
                                    </tr>
                                </thead>
                                <tbody style="color:black">
                                    <!-- BASOSAPI -->
                                    <tr style="background-color:aqua;">
                                        <th class="text-center align-middle" rowspan="2">BASOSAPI</th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar1"
                                                value="{{ @$jadwal->penyiar1 }}" required onchange="update_custom(this)">
                                        </th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar2"
                                                value="{{ @$jadwal->penyiar2 }}" required onchange="update_custom(this)">
                                        </th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar3"
                                                value="{{ @$jadwal->penyiar3 }}" required onchange="update_custom(this)">
                                        </th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar4"
                                                value="{{ @$jadwal->penyiar4 }}" required onchange="update_custom(this)">
                                        </th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar5"
                                                value="{{ @$jadwal->penyiar5 }}" required onchange="update_custom(this)">
                                        </th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar6"
                                                value="{{ @$jadwal->penyiar6 }}" required onchange="update_custom(this)">
                                        </th>
                                    </tr>
                                    <tr style="background-color:aqua;">
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar7"
                                                value="{{ @$jadwal->penyiar7 }}" required onchange="update_custom(this)">
                                        </th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar8"
                                                value="{{ @$jadwal->penyiar8 }}" required onchange="update_custom(this)">
                                        </th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar9"
                                                value="{{ @$jadwal->penyiar9 }}" required onchange="update_custom(this)">
                                        </th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar10"
                                                value="{{ @$jadwal->penyiar10 }}" required onchange="update_custom(this)">
                                        </th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar11"
                                                value="{{ @$jadwal->penyiar11 }}" required onchange="update_custom(this)">
                                        </th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar12"
                                                value="{{ @$jadwal->penyiar12 }}" required onchange="update_custom(this)">
                                        </th>
                                    </tr>

                                    <!-- 11N1 -->
                                    <tr style="background-color:darkgray;">
                                        <th class="text-center align-middle" rowspan="2">11N1</th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar13"
                                                value="{{ @$jadwal->penyiar13 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar14"
                                                value="{{ @$jadwal->penyiar14 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar15"
                                                value="{{ @$jadwal->penyiar15 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar16"
                                                value="{{ @$jadwal->penyiar16 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar17"
                                                value="{{ @$jadwal->penyiar17 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color:forestgreen;"><input type="text"
                                                class="form-jadwal-siar" name="penyiar18"
                                                value="{{ @$jadwal->penyiar18 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>
                                    <tr style="background-color:darkgray;">
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar19"
                                                value="{{ @$jadwal->penyiar19 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar20"
                                                value="{{ @$jadwal->penyiar20 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar21"
                                                value="{{ @$jadwal->penyiar21 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar22"
                                                value="{{ @$jadwal->penyiar22 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar23"
                                                value="{{ @$jadwal->penyiar23 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color:forestgreen;"><input type="text"
                                                class="form-jadwal-siar" name="penyiar24"
                                                value="{{ @$jadwal->penyiar24 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>

                                    <!-- RAPMANESIA -->
                                    <tr style="background-color:red;">
                                        <th class="text-center align-middle" rowspan="2">RAPMANESIA</th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar25"
                                                value="{{ @$jadwal->penyiar25 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar26"
                                                value="{{ @$jadwal->penyiar26 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar27"
                                                value="{{ @$jadwal->penyiar27 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar28"
                                                value="{{ @$jadwal->penyiar28 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar29"
                                                value="{{ @$jadwal->penyiar29 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color:forestgreen;"><input type="text"
                                                class="form-jadwal-siar" name="penyiar30"
                                                value="{{ @$jadwal->penyiar30 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>
                                    <tr style="background-color:red;">
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar31"
                                                value="{{ @$jadwal->penyiar31 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar32"
                                                value="{{ @$jadwal->penyiar32 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar33"
                                                value="{{ @$jadwal->penyiar33 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar34"
                                                value="{{ @$jadwal->penyiar34 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar35"
                                                value="{{ @$jadwal->penyiar35 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color:forestgreen;"><input type="text"
                                                class="form-jadwal-siar" name="penyiar36"
                                                value="{{ @$jadwal->penyiar36 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>

                                    <!-- THE GOOD VIBES -->
                                    <tr style="background-color:yellow;">
                                        <th class="text-center align-middle" rowspan="2">THE GOOD VIBES</th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar37"
                                                value="{{ @$jadwal->penyiar37 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar38"
                                                value="{{ @$jadwal->penyiar38 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar39"
                                                value="{{ @$jadwal->penyiar39 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar40"
                                                value="{{ @$jadwal->penyiar40 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar41"
                                                value="{{ @$jadwal->penyiar41 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color:forestgreen;"><input type="text"
                                                class="form-jadwal-siar" name="penyiar42"
                                                value="{{ @$jadwal->penyiar42 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>
                                    <tr style="background-color:yellow;">
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar43"
                                                value="{{ @$jadwal->penyiar43 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar44"
                                                value="{{ @$jadwal->penyiar44 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar45"
                                                value="{{ @$jadwal->penyiar45 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar46"
                                                value="{{ @$jadwal->penyiar46 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar47"
                                                value="{{ @$jadwal->penyiar47 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color:forestgreen;"><input type="text"
                                                class="form-jadwal-siar" name="penyiar48"
                                                value="{{ @$jadwal->penyiar48 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>

                                    <!-- KHASANAH PETANG -->
                                    <tr style="background-color:coral;">
                                        <th class="text-center align-middle" rowspan="2">KHASANAH PETANG</th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar49"
                                                value="{{ @$jadwal->penyiar49 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar50"
                                                value="{{ @$jadwal->penyiar50 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar51"
                                                value="{{ @$jadwal->penyiar51 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar52"
                                                value="{{ @$jadwal->penyiar52 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar53"
                                                value="{{ @$jadwal->penyiar53 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar54"
                                                value="{{ @$jadwal->penyiar54 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>
                                    <tr style="background-color:coral;">
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar55"
                                                value="{{ @$jadwal->penyiar55 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar56"
                                                value="{{ @$jadwal->penyiar56 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar57"
                                                value="{{ @$jadwal->penyiar57 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar58"
                                                value="{{ @$jadwal->penyiar58 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar59"
                                                value="{{ @$jadwal->penyiar59 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar60"
                                                value="{{ @$jadwal->penyiar60 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>

                                    <!-- MUSIC BOX -->
                                    <tr style="background-color:orange;">
                                        <th class="text-center align-middle" rowspan="2">MUSIC BOX</th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar61"
                                                value="{{ @$jadwal->penyiar61 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar62"
                                                value="{{ @$jadwal->penyiar62 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar63"
                                                value="{{ @$jadwal->penyiar63 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar64"
                                                value="{{ @$jadwal->penyiar64 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar65"
                                                value="{{ @$jadwal->penyiar65 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color:forestgreen;"><input type="text"
                                                class="form-jadwal-siar" name="penyiar66"
                                                value="{{ @$jadwal->penyiar66 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>
                                    <tr style="background-color:orange;">
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar67"
                                                value="{{ @$jadwal->penyiar67 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar68"
                                                value="{{ @$jadwal->penyiar68 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar69"
                                                value="{{ @$jadwal->penyiar69 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar70"
                                                value="{{ @$jadwal->penyiar70 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar71"
                                                value="{{ @$jadwal->penyiar71 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color:forestgreen;"><input type="text"
                                                class="form-jadwal-siar" name="penyiar72"
                                                value="{{ @$jadwal->penyiar72 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>

                                    <!-- SPECIAL PROGRAM -->
                                    <tr style="background-color:forestgreen;">
                                        <th class="text-center align-middle" rowspan="2">SPECIAL PROGRAM</th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar73"
                                                value="{{ @$jadwal->penyiar73 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar74"
                                                value="{{ @$jadwal->penyiar74 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar75"
                                                value="{{ @$jadwal->penyiar75 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar76"
                                                value="{{ @$jadwal->penyiar76 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar77"
                                                value="{{ @$jadwal->penyiar77 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar78"
                                                value="{{ @$jadwal->penyiar78 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>
                                    <tr style="background-color:forestgreen;">
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar79"
                                                value="{{ @$jadwal->penyiar79 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar80"
                                                value="{{ @$jadwal->penyiar80 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar81"
                                                value="{{ @$jadwal->penyiar81 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar82"
                                                value="{{ @$jadwal->penyiar82 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar83"
                                                value="{{ @$jadwal->penyiar83 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar84"
                                                value="{{ @$jadwal->penyiar84 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>

                                    <!-- AFTERDAY -->
                                    <tr style="background-color:dodgerblue;">
                                        <th class="text-center align-middle" rowspan="2">AFTERDAY</th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar85"
                                                value="{{ @$jadwal->penyiar85 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar86"
                                                value="{{ @$jadwal->penyiar86 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar87"
                                                value="{{ @$jadwal->penyiar87 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color:forestgreen;"><input type="text"
                                                class="form-jadwal-siar" name="penyiar88"
                                                value="{{ @$jadwal->penyiar88 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar89"
                                                value="{{ @$jadwal->penyiar89 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar90"
                                                value="{{ @$jadwal->penyiar90 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>
                                    <tr style="background-color:dodgerblue;">
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar91"
                                                value="{{ @$jadwal->penyiar91 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar92"
                                                value="{{ @$jadwal->penyiar92 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar93"
                                                value="{{ @$jadwal->penyiar93 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color:forestgreen;"><input type="text"
                                                class="form-jadwal-siar" name="penyiar94"
                                                value="{{ @$jadwal->penyiar94 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar95"
                                                value="{{ @$jadwal->penyiar95 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th><input type="text" class="form-jadwal-siar" name="penyiar96"
                                                value="{{ @$jadwal->penyiar96 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function update_custom(ctx) {
            let id = {{ $jadwal->id }};
            let tabel = 'jadwal_siar';
            let kolom = $(ctx).prop('name');
            let value = null;

            $.ajax({
                type: "POST",
                url: "{{ route('jadwal-siar.update_custom') }}",
                data: {
                    id: id ?? '{{ $jadwal->id }}',
                    tabel: tabel,
                    kolom: kolom ?? $(ctx).prop('name'),
                    value: value ?? $(ctx).val(),
                },
                dataType: "JSON",
            }).then(res => {
                if (res.status) {
                    toastr.success(res.message, 'Sukses')
                    table.ajax.reload();
                }
            })
        }
    </script>
@endpush

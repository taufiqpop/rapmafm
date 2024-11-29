@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal'];
@endphp

@push('styles')
    <style>
        .table-jadwal-piket {
            border: 3px solid #000;
        }

        .table-jadwal-piket th,
        .table-jadwal-piket td {
            border: 3px solid #000;
        }

        .table-jadwal-piket thead th,
        .table-jadwal-piket thead td {
            border-bottom-width: 1px;
        }

        .form-jadwal-piket {
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
                        <input type="date" class="form-jadwal-piket" name="tgl_mulai" value="{{ @$jadwal->tgl_mulai }}"
                            required onchange="update_custom(this)">
                    </div>
                    <label for="tgl_selesai" class="col-form-label">-</label>
                    <div class="col-sm-2">
                        <input type="date" class="form-jadwal-piket" name="tgl_selesai"
                            value="{{ @$jadwal->tgl_selesai }}" required onchange="update_custom(this)">
                    </div>
                </div>

                {{-- Button Back --}}
                <div class="mb-3">
                    <a href="{{ route('jadwal-piket') }}" class="btn btn-dark"><i class="bx bx-arrow-back"></i>
                        Back</a>
                </div>

                <!-- Table -->
                <div class="row card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-jadwal-piket" width="100%" cellspacing="0">
                                <thead>
                                    <tr style="background-color: antiquewhite; color:black;">
                                        <th class="text-center">Senin</th>
                                        <th class="text-center">Selasa</th>
                                        <th class="text-center">Rabu</th>
                                        <th class="text-center">Kamis</th>
                                        <th class="text-center">Jum'at</th>
                                        <th class="text-center">Sabtu</th>
                                    </tr>
                                </thead>
                                <tbody style="color:black">
                                    <!-- Row 1 -->
                                    <tr>
                                        <th style="background-color: aqua;"><input type="text" class="form-jadwal-piket"
                                                name="anggota1" value="{{ @$jadwal->anggota1 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: violet;"><input type="text"
                                                class="form-jadwal-piket" name="anggota2" value="{{ @$jadwal->anggota2 }}"
                                                required></th>
                                        <th style="background-color: yellowgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota3" value="{{ @$jadwal->anggota3 }}"
                                                required></th>
                                        <th style="background-color: dodgerblue;"><input type="text"
                                                class="form-jadwal-piket" name="anggota4" value="{{ @$jadwal->anggota4 }}"
                                                required></th>
                                        <th style="background-color: coral;"><input type="text" class="form-jadwal-piket"
                                                name="anggota5" value="{{ @$jadwal->anggota5 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: forestgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota6" value="{{ @$jadwal->anggota6 }}"
                                                required></th>
                                    </tr>

                                    <!-- Row 2 -->
                                    <tr>
                                        <th style="background-color: aqua;"><input type="text" class="form-jadwal-piket"
                                                name="anggota7" value="{{ @$jadwal->anggota7 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: violet;"><input type="text"
                                                class="form-jadwal-piket" name="anggota8" value="{{ @$jadwal->anggota8 }}"
                                                required></th>
                                        <th style="background-color: yellowgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota9" value="{{ @$jadwal->anggota9 }}"
                                                required></th>
                                        <th style="background-color: dodgerblue;"><input type="text"
                                                class="form-jadwal-piket" name="anggota10"
                                                value="{{ @$jadwal->anggota10 }}" required onchange="update_custom(this)">
                                        </th>
                                        <th style="background-color: coral;"><input type="text" class="form-jadwal-piket"
                                                name="anggota11" value="{{ @$jadwal->anggota11 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: forestgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota12"
                                                value="{{ @$jadwal->anggota12 }}" required
                                                onchange="update_custom(this)">
                                        </th>
                                    </tr>

                                    <!-- Row 3 -->
                                    <tr>
                                        <th style="background-color: aqua;"><input type="text"
                                                class="form-jadwal-piket" name="anggota13"
                                                value="{{ @$jadwal->anggota13 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: violet;"><input type="text"
                                                class="form-jadwal-piket" name="anggota14"
                                                value="{{ @$jadwal->anggota14 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: yellowgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota15"
                                                value="{{ @$jadwal->anggota15 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: dodgerblue;"><input type="text"
                                                class="form-jadwal-piket" name="anggota16"
                                                value="{{ @$jadwal->anggota16 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: coral;"><input type="text"
                                                class="form-jadwal-piket" name="anggota17"
                                                value="{{ @$jadwal->anggota17 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: forestgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota18"
                                                value="{{ @$jadwal->anggota18 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>

                                    <!-- Row 4 -->
                                    <tr>
                                        <th style="background-color: aqua;"><input type="text"
                                                class="form-jadwal-piket" name="anggota19"
                                                value="{{ @$jadwal->anggota19 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: violet;"><input type="text"
                                                class="form-jadwal-piket" name="anggota20"
                                                value="{{ @$jadwal->anggota20 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: yellowgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota21"
                                                value="{{ @$jadwal->anggota21 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: dodgerblue;"><input type="text"
                                                class="form-jadwal-piket" name="anggota22"
                                                value="{{ @$jadwal->anggota22 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: coral;"><input type="text"
                                                class="form-jadwal-piket" name="anggota23"
                                                value="{{ @$jadwal->anggota23 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: forestgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota24"
                                                value="{{ @$jadwal->anggota24 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>

                                    <!-- Row 5 -->
                                    <tr>
                                        <th style="background-color: aqua;"><input type="text"
                                                class="form-jadwal-piket" name="anggota25"
                                                value="{{ @$jadwal->anggota25 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: violet;"><input type="text"
                                                class="form-jadwal-piket" name="anggota26"
                                                value="{{ @$jadwal->anggota26 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: yellowgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota27"
                                                value="{{ @$jadwal->anggota27 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: dodgerblue;"><input type="text"
                                                class="form-jadwal-piket" name="anggota28"
                                                value="{{ @$jadwal->anggota28 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: coral;"><input type="text"
                                                class="form-jadwal-piket" name="anggota29"
                                                value="{{ @$jadwal->anggota29 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: forestgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota30"
                                                value="{{ @$jadwal->anggota30 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>

                                    <!-- Row 6 -->
                                    <tr>
                                        <th style="background-color: aqua;"><input type="text"
                                                class="form-jadwal-piket" name="anggota31"
                                                value="{{ @$jadwal->anggota31 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: violet;"><input type="text"
                                                class="form-jadwal-piket" name="anggota32"
                                                value="{{ @$jadwal->anggota32 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: yellowgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota33"
                                                value="{{ @$jadwal->anggota33 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: dodgerblue;"><input type="text"
                                                class="form-jadwal-piket" name="anggota34"
                                                value="{{ @$jadwal->anggota34 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: coral;"><input type="text"
                                                class="form-jadwal-piket" name="anggota35"
                                                value="{{ @$jadwal->anggota35 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: forestgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota36"
                                                value="{{ @$jadwal->anggota36 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>

                                    <!-- Row 7 -->
                                    <tr>
                                        <th style="background-color: aqua;"><input type="text"
                                                class="form-jadwal-piket" name="anggota37"
                                                value="{{ @$jadwal->anggota37 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: violet;"><input type="text"
                                                class="form-jadwal-piket" name="anggota38"
                                                value="{{ @$jadwal->anggota38 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: yellowgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota39"
                                                value="{{ @$jadwal->anggota39 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: dodgerblue;"><input type="text"
                                                class="form-jadwal-piket" name="anggota40"
                                                value="{{ @$jadwal->anggota40 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: coral;"><input type="text"
                                                class="form-jadwal-piket" name="anggota41"
                                                value="{{ @$jadwal->anggota41 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: forestgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota42"
                                                value="{{ @$jadwal->anggota42 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>

                                    <!-- Row 8 -->
                                    <tr>
                                        <th style="background-color: aqua;"><input type="text"
                                                class="form-jadwal-piket" name="anggota43"
                                                value="{{ @$jadwal->anggota43 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: violet;"><input type="text"
                                                class="form-jadwal-piket" name="anggota44"
                                                value="{{ @$jadwal->anggota44 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: yellowgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota45"
                                                value="{{ @$jadwal->anggota45 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: dodgerblue;"><input type="text"
                                                class="form-jadwal-piket" name="anggota46"
                                                value="{{ @$jadwal->anggota46 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: coral;"><input type="text"
                                                class="form-jadwal-piket" name="anggota47"
                                                value="{{ @$jadwal->anggota47 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: forestgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota48"
                                                value="{{ @$jadwal->anggota48 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>

                                    <!-- Row 9 -->
                                    <tr>
                                        <th style="background-color: aqua;"><input type="text"
                                                class="form-jadwal-piket" name="anggota49"
                                                value="{{ @$jadwal->anggota49 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: violet;"><input type="text"
                                                class="form-jadwal-piket" name="anggota50"
                                                value="{{ @$jadwal->anggota50 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: yellowgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota51"
                                                value="{{ @$jadwal->anggota51 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: dodgerblue;"><input type="text"
                                                class="form-jadwal-piket" name="anggota52"
                                                value="{{ @$jadwal->anggota52 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: coral;"><input type="text"
                                                class="form-jadwal-piket" name="anggota53"
                                                value="{{ @$jadwal->anggota53 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: forestgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota54"
                                                value="{{ @$jadwal->anggota54 }}" required
                                                onchange="update_custom(this)"></th>
                                    </tr>

                                    <!-- Row 10 -->
                                    <tr>
                                        <th style="background-color: aqua;"><input type="text"
                                                class="form-jadwal-piket" name="anggota55"
                                                value="{{ @$jadwal->anggota55 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: violet;"><input type="text"
                                                class="form-jadwal-piket" name="anggota56"
                                                value="{{ @$jadwal->anggota56 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: yellowgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota57"
                                                value="{{ @$jadwal->anggota57 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: dodgerblue;"><input type="text"
                                                class="form-jadwal-piket" name="anggota58"
                                                value="{{ @$jadwal->anggota58 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: coral;"><input type="text"
                                                class="form-jadwal-piket" name="anggota59"
                                                value="{{ @$jadwal->anggota59 }}" required
                                                onchange="update_custom(this)"></th>
                                        <th style="background-color: forestgreen;"><input type="text"
                                                class="form-jadwal-piket" name="anggota60"
                                                value="{{ @$jadwal->anggota60 }}" required
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
            let tabel = 'jadwal_piket';
            let kolom = $(ctx).prop('name');
            let value = null;

            $.ajax({
                type: "POST",
                url: "{{ route('jadwal-piket.update_custom') }}",
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

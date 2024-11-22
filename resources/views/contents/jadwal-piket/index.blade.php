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
                <center>
                    <h1 class="h1 mb-4 text-gray-800">
                        <b>Jadwal Piket</b>
                    </h1>
                    <h4 class="h4 mb-4 text-gray-800">
                        ({{ \Carbon\Carbon::parse($jadwal->tgl_mulai)->locale('id')->translatedFormat('l, d F Y') }})
                        - ({{ \Carbon\Carbon::parse($jadwal->tgl_selesai)->locale('id')->translatedFormat('l, d F Y') }})
                    </h4>
                    @if (rbacCheck('jadwal_piket', 3))
                        <div class="mb-4">
                            <a href="{{ route('jadwal-piket.edit') }}" class="btn btn-primary"><i class="bx bxs-edit"></i> Edit
                                Jadwal</a>
                        </div>
                    @endif
                </center>

                <!-- Table -->
                <div class="row card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-jadwal-piket" width="100%" cellspacing="0">
                                <thead>
                                    <tr style="background-color: orange; color:black; font-size:large">
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
                                        <th class="text-center" style="background-color: aqua;">{{ @$jadwal->anggota1 }}
                                        </th>
                                        <th class="text-center" style="background-color: violet;">{{ @$jadwal->anggota2 }}
                                        </th>
                                        <th class="text-center" style="background-color: yellowgreen;">
                                            {{ @$jadwal->anggota3 }}</th>
                                        <th class="text-center" style="background-color: dodgerblue;">
                                            {{ @$jadwal->anggota4 }}</th>
                                        <th class="text-center" style="background-color: coral;">{{ @$jadwal->anggota5 }}
                                        </th>
                                        <th class="text-center" style="background-color: forestgreen;">
                                            {{ @$jadwal->anggota6 }}</th>
                                    </tr>

                                    <!-- Row 2 -->
                                    <tr>
                                        <th class="text-center" style="background-color: aqua;">{{ @$jadwal->anggota7 }}
                                        </th>
                                        <th class="text-center" style="background-color: violet;">{{ @$jadwal->anggota8 }}
                                        </th>
                                        <th class="text-center" style="background-color: yellowgreen;">
                                            {{ @$jadwal->anggota9 }}</th>
                                        <th class="text-center" style="background-color: dodgerblue;">
                                            {{ @$jadwal->anggota10 }}</th>
                                        <th class="text-center" style="background-color: coral;">{{ @$jadwal->anggota11 }}
                                        </th>
                                        <th class="text-center" style="background-color: forestgreen;">
                                            {{ @$jadwal->anggota12 }}</th>
                                    </tr>

                                    <!-- Row 3 -->
                                    <tr>
                                        <th class="text-center" style="background-color: aqua;">{{ @$jadwal->anggota13 }}
                                        </th>
                                        <th class="text-center" style="background-color: violet;">{{ @$jadwal->anggota14 }}
                                        </th>
                                        <th class="text-center" style="background-color: yellowgreen;">
                                            {{ @$jadwal->anggota15 }}</th>
                                        <th class="text-center" style="background-color: dodgerblue;">
                                            {{ @$jadwal->anggota16 }}</th>
                                        <th class="text-center" style="background-color: coral;">{{ @$jadwal->anggota17 }}
                                        </th>
                                        <th class="text-center" style="background-color: forestgreen;">
                                            {{ @$jadwal->anggota18 }}</th>
                                    </tr>

                                    <!-- Row 4 -->
                                    <tr>
                                        <th class="text-center" style="background-color: aqua;">{{ @$jadwal->anggota19 }}
                                        </th>
                                        <th class="text-center" style="background-color: violet;">{{ @$jadwal->anggota20 }}
                                        </th>
                                        <th class="text-center" style="background-color: yellowgreen;">
                                            {{ @$jadwal->anggota21 }}</th>
                                        <th class="text-center" style="background-color: dodgerblue;">
                                            {{ @$jadwal->anggota22 }}</th>
                                        <th class="text-center" style="background-color: coral;">{{ @$jadwal->anggota23 }}
                                        </th>
                                        <th class="text-center" style="background-color: forestgreen;">
                                            {{ @$jadwal->anggota24 }}</th>
                                    </tr>

                                    <!-- Row 5 -->
                                    <tr>
                                        <th class="text-center" style="background-color: aqua;">{{ @$jadwal->anggota25 }}
                                        </th>
                                        <th class="text-center" style="background-color: violet;">{{ @$jadwal->anggota26 }}
                                        </th>
                                        <th class="text-center" style="background-color: yellowgreen;">
                                            {{ @$jadwal->anggota27 }}</th>
                                        <th class="text-center" style="background-color: dodgerblue;">
                                            {{ @$jadwal->anggota28 }}</th>
                                        <th class="text-center" style="background-color: coral;">{{ @$jadwal->anggota29 }}
                                        </th>
                                        <th class="text-center" style="background-color: forestgreen;">
                                            {{ @$jadwal->anggota30 }}</th>
                                    </tr>

                                    <!-- Row 6 -->
                                    <tr>
                                        <th class="text-center" style="background-color: aqua;">{{ @$jadwal->anggota31 }}
                                        </th>
                                        <th class="text-center" style="background-color: violet;">{{ @$jadwal->anggota32 }}
                                        </th>
                                        <th class="text-center" style="background-color: yellowgreen;">
                                            {{ @$jadwal->anggota33 }}</th>
                                        <th class="text-center" style="background-color: dodgerblue;">
                                            {{ @$jadwal->anggota34 }}</th>
                                        <th class="text-center" style="background-color: coral;">{{ @$jadwal->anggota35 }}
                                        </th>
                                        <th class="text-center" style="background-color: forestgreen;">
                                            {{ @$jadwal->anggota36 }}</th>
                                    </tr>

                                    <!-- Row 7 -->
                                    <tr>
                                        <th class="text-center" style="background-color: aqua;">{{ @$jadwal->anggota37 }}
                                        </th>
                                        <th class="text-center" style="background-color: violet;">{{ @$jadwal->anggota38 }}
                                        </th>
                                        <th class="text-center" style="background-color: yellowgreen;">
                                            {{ @$jadwal->anggota39 }}</th>
                                        <th class="text-center" style="background-color: dodgerblue;">
                                            {{ @$jadwal->anggota40 }}</th>
                                        <th class="text-center" style="background-color: coral;">
                                            {{ @$jadwal->anggota41 }}</th>
                                        <th class="text-center" style="background-color: forestgreen;">
                                            {{ @$jadwal->anggota42 }}</th>
                                    </tr>

                                    <!-- Row 8 -->
                                    <tr>
                                        <th class="text-center" style="background-color: aqua;">{{ @$jadwal->anggota43 }}
                                        </th>
                                        <th class="text-center" style="background-color: violet;">
                                            {{ @$jadwal->anggota44 }}</th>
                                        <th class="text-center" style="background-color: yellowgreen;">
                                            {{ @$jadwal->anggota45 }}</th>
                                        <th class="text-center" style="background-color: dodgerblue;">
                                            {{ @$jadwal->anggota46 }}</th>
                                        <th class="text-center" style="background-color: coral;">
                                            {{ @$jadwal->anggota47 }}</th>
                                        <th class="text-center" style="background-color: forestgreen;">
                                            {{ @$jadwal->anggota48 }}</th>
                                    </tr>

                                    <!-- Row 9 -->
                                    <tr>
                                        <th class="text-center" style="background-color: aqua;">{{ @$jadwal->anggota49 }}
                                        </th>
                                        <th class="text-center" style="background-color: violet;">
                                            {{ @$jadwal->anggota50 }}</th>
                                        <th class="text-center" style="background-color: yellowgreen;">
                                            {{ @$jadwal->anggota51 }}</th>
                                        <th class="text-center" style="background-color: dodgerblue;">
                                            {{ @$jadwal->anggota52 }}</th>
                                        <th class="text-center" style="background-color: coral;">
                                            {{ @$jadwal->anggota53 }}</th>
                                        <th class="text-center" style="background-color: forestgreen;">
                                            {{ @$jadwal->anggota54 }}</th>
                                    </tr>

                                    <!-- Row 10 -->
                                    <tr>
                                        <th class="text-center" style="background-color: aqua;">{{ @$jadwal->anggota55 }}
                                        </th>
                                        <th class="text-center" style="background-color: violet;">
                                            {{ @$jadwal->anggota56 }}</th>
                                        <th class="text-center" style="background-color: yellowgreen;">
                                            {{ @$jadwal->anggota57 }}</th>
                                        <th class="text-center" style="background-color: dodgerblue;">
                                            {{ @$jadwal->anggota58 }}</th>
                                        <th class="text-center" style="background-color: coral;">
                                            {{ @$jadwal->anggota59 }}</th>
                                        <th class="text-center" style="background-color: forestgreen;">
                                            {{ @$jadwal->anggota60 }}</th>
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
@endpush

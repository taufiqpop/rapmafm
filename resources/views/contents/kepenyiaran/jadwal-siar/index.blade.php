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
                <center>
                    <h1 class="h1 mb-4 text-gray-800">
                        <b>Jadwal Siar</b>
                    </h1>
                    <h4 class="h4 mb-4 text-gray-800">
                        ({{ \Carbon\Carbon::parse($jadwal->tgl_mulai)->locale('id')->translatedFormat('l, d F Y') }})
                        - ({{ \Carbon\Carbon::parse($jadwal->tgl_selesai)->locale('id')->translatedFormat('l, d F Y') }})
                    </h4>
                    @if (rbacCheck('jadwal_siar', 3))
                        <div class="mb-4">
                            <a href="{{ route('jadwal-siar.edit') }}" class="btn btn-primary"><i class="bx bxs-edit"></i> Edit
                                Penyiar</a>
                        </div>
                    @endif
                </center>

                <!-- Table -->
                <div class="row card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-jadwal-siar" width="100%" cellspacing="0">
                                <thead>
                                    <tr style="background-color: antiquewhite; color:black; font-size:large">
                                        <th class="text-center">Program Siar</th>
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
                                    <tr style="background-color: aqua;">
                                        <th class="text-center align-middle" rowspan="2">BASOSAPI</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar1 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar2 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar3 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar4 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar5 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar6 }}</th>
                                    </tr>
                                    <tr style="background-color: aqua;">
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar7 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar8 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar9 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar10 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar11 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar12 }}</th>
                                    </tr>

                                    <!-- 11N1 -->
                                    <tr style="background-color: darkgray;">
                                        <th class="text-center align-middle" rowspan="2">11N1</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar13 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar14 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar15 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar16 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar17 }}</th>
                                        <th style="background-color:forestgreen;">{{ @$jadwal->penyiar18 }}</th>
                                    </tr>
                                    <tr style="background-color: darkgray;">
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar19 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar20 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar21 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar22 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar23 }}</th>
                                        <th style="background-color:forestgreen;">{{ @$jadwal->penyiar24 }}</th>
                                    </tr>

                                    <!-- RAPMANESIA -->
                                    <tr style="background-color: red;">
                                        <th class="text-center align-middle" rowspan="2">RAPMANESIA</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar25 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar26 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar27 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar28 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar29 }}</th>
                                        <th style="background-color:chartreuse;">{{ @$jadwal->penyiar30 }}</th>
                                    </tr>
                                    <tr style="background-color: red;">
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar31 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar32 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar33 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar34 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar35 }}</th>
                                        <th style="background-color:chartreuse;">{{ @$jadwal->penyiar36 }}</th>
                                    </tr>


                                    <!-- THE GOOD VIBES -->
                                    <tr style="background-color: yellow;">
                                        <th class="text-center align-middle" rowspan="2">THE GOOD VIBES</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar37 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar38 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar39 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar40 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar41 }}</th>
                                        <th style="background-color:forestgreen;">{{ @$jadwal->penyiar42 }}</th>
                                    </tr>
                                    <tr style="background-color: yellow;">
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar43 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar44 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar45 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar46 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar47 }}</th>
                                        <th style="background-color:forestgreen;">{{ @$jadwal->penyiar48 }}</th>
                                    </tr>

                                    <!-- KHASANAH PETANG -->
                                    <tr style="background-color: coral;">
                                        <th class="text-center align-middle" rowspan="2">KHASANAH PETANG</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar49 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar50 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar51 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar52 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar53 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar54 }}</th>
                                    </tr>
                                    <tr style="background-color: coral;">
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar55 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar56 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar57 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar58 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar59 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar60 }}</th>
                                    </tr>

                                    <!-- MUSIC BOX -->
                                    <tr style="background-color: orange;">
                                        <th class="text-center align-middle" rowspan="2">MUSIC BOX</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar61 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar62 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar63 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar64 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar65 }}</th>
                                        <th style="background-color:forestgreen;">{{ @$jadwal->penyiar66 }}</th>
                                    </tr>
                                    <tr style="background-color: orange;">
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar67 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar68 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar69 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar70 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar71 }}</th>
                                        <th style="background-color:forestgreen;">{{ @$jadwal->penyiar72 }}</th>
                                    </tr>

                                    <!-- SPECIAL PROGRAM -->
                                    <tr style="background-color: forestgreen;">
                                        <th class="text-center align-middle" rowspan="2">SPECIAL PROGRAM</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar73 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar74 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar75 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar76 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar77 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar78 }}</th>
                                    </tr>
                                    <tr style="background-color: forestgreen;">
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar79 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar80 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar81 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar82 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar83 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar84 }}</th>
                                    </tr>

                                    <!-- AFTERDAY -->
                                    <tr style="background-color: dodgerblue;">
                                        <th class="text-center align-middle" rowspan="2">AFTERDAY</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar85 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar86 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar87 }}</th>
                                        <th style="background-color:forestgreen;">{{ @$jadwal->penyiar88 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar89 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar90 }}</th>
                                    </tr>
                                    <tr style="background-color: dodgerblue;">
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar91 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar92 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar93 }}</th>
                                        <th style="background-color:forestgreen;">{{ @$jadwal->penyiar94 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar95 }}</th>
                                        <th class="text-center align-middle">{{ @$jadwal->penyiar96 }}</th>
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

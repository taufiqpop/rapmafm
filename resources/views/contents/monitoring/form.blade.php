@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

@push('styles')
    <style>
        .styled-textarea {
            border: 2px solid #ced4da;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            line-height: 1.5;
            transition: border-color 0.3s, box-shadow 0.3s;
            resize: vertical;
            background-color: #f8f9fa;
        }

        .styled-textarea:focus {
            border-color: #6c757d;
            box-shadow: 0 0 10px rgba(108, 117, 125, 0.2);
        }
    </style>
@endpush

@section('contents')
    {{-- Monitoring --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>
                                Form {{ $title }} - {{ $sekolah->nama }} ({{ $sekolah->kelas }}
                                {{ $sekolah->kode_kelas }})
                            </h3>
                            <hr>
                        </div>
                        <div class="col-md-6 mt-2">
                            <table class="table table-bordered table-hover" id="dt-form">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center align-middle">N</th>
                                        <th scope="col" class="text-center align-middle">Minimum</th>
                                        <th scope="col" class="text-center align-middle">Maximum</th>
                                        <th scope="col" class="text-center align-middle">MEAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="col" class="text-center align-middle">{{ $sekolah->jumlah_siswa }}
                                        </td>
                                        <td scope="col" class="text-center align-middle">{{ $sekolah->minimal }}</td>
                                        <td scope="col" class="text-center align-middle">{{ $sekolah->maksimal }}</td>
                                        <td scope="col" class="text-center align-middle">{{ $sekolah->mean }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div>
                                <label for="hasil_monitoring">
                                    <h4>Hasil Monitoring Peserta Didik :</h4>
                                </label>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-info btn-kriteria" data-toggle="modal"
                                        data-target="#monitoringModal"><i class="fas fa-info-circle"></i> Contoh</button>
                                </div>
                                <textarea class="form-control styled-textarea" name="hasil_monitoring" id="hasil_monitoring" cols="30"
                                    rows="10" placeholder="Masukkan Hasil Monitoring Peserta Didik.." data-tabel="sekolah"
                                    data-kolom="hasil_monitoring" onchange="update_custom(this)">{{ $sekolah->hasil_monitoring }}</textarea>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-dark" onclick="history.back()"><i class="bx bx-arrow-back"></i>
                                    Kembali</button>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            {{-- Pie Chart --}}
                            <div id="pieChartMonitoring" style="width: 100%; height: 430px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Monitoring Peserta Didik --}}
    <div class="modal fade" id="monitoringModal" tabindex="-1" role="dialog" aria-labelledby="monitoringModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="monitoringModalLabel">Monitoring Peserta Didik</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <h5>Contoh :</h5>
                        <p class="text-justify">
                            Terdapat 20% siswa yang mendapatkan skor 61-70 dan 35% siswa yang mendapatkan skor 71-80.
                            Kondisi
                            tersebut perlu diidentifikasi secara mendalam, kesulitan belajar apa yang dialami siswa? Apakah
                            pada materi
                            konsep laporan arus kas? Materi perhitungan laporan arus kas? Materi penyusunan laporan arus
                            kas?
                            Selain itu, attitude siswa juga perlu diperhatikan agar setiap siswa dapat aktif dalam
                            pembelajaran, dan
                            berani mengemukakan gagasan, serta ,elatih kepekaan rasa saat berdiskusi.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <script>
        $(document).ready(function() {
            renderPieChart(@json($pieChartData));
        });

        function update_custom(ctx) {
            let id = $(ctx).data('id');
            let tabel = $(ctx).data('tabel');
            let kolom = $(ctx).data('kolom');
            let value = null;

            $.ajax({
                type: "POST",
                url: "{{ route('monitoring.update_custom') }}",
                data: {
                    id: id ?? '{{ $sekolah->id }}',
                    tabel: tabel,
                    kolom: kolom ?? $(ctx).prop('name'),
                    value: value ?? $(ctx).val(),
                },
                dataType: "JSON",
            }).then(res => {
                if (res.status) {
                    toastr.success(res.message, 'Sukses');
                    table.ajax.reload();
                }
            });
        }

        // Pie Chart
        function renderPieChart(pieChartData) {
            am5.ready(function() {
                let root = am5.Root.new("pieChartMonitoring");

                root.setThemes([
                    am5themes_Animated.new(root)
                ]);

                let chart = root.container.children.push(am5percent.PieChart.new(root, {
                    layout: root.verticalLayout
                }));

                let series = chart.series.push(am5percent.PieSeries.new(root, {
                    valueField: "value",
                    categoryField: "category"
                }));

                series.get("colors").set("colors", [
                    am5.color(0xFF5733), // Merah
                    am5.color(0xFFD700), // Kuning
                    am5.color(0x8E44AD), // Ungu
                    am5.color(0x3357FF), // Biru
                    am5.color(0x33FF57), // Hijau
                ]);

                series.data.setAll([{
                        category: "<60",
                        value: pieChartData.dibawah60
                    },
                    {
                        category: "61-70",
                        value: pieChartData.antara6070
                    },
                    {
                        category: "71-80",
                        value: pieChartData.antara7080
                    },
                    {
                        category: "81-90",
                        value: pieChartData.antara8090
                    },
                    {
                        category: ">90",
                        value: pieChartData.diatas90
                    },
                ]);

                chart.children.push(am5.Legend.new(root, {
                    centerX: am5.percent(50),
                    x: am5.percent(50),
                    marginTop: 15,
                    marginBottom: 15
                }));
            });
        }
    </script>
@endpush

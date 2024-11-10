@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

@section('contents')
    <style>
        .question-button {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            animation: blink 1s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                filter: brightness(100%);
            }

            50% {
                filter: brightness(200%);
            }
        }
    </style>
    {{-- Ketercapaian --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {{-- Button Modal Information --}}
                    <div class="d-flex justify-content-end">
                        <div class="question-button" data-toggle="modal" data-target="#infoModal">
                            <i class="fas fa-question"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h3>{{ $title }}</h3>
                        </div>
                        <div class="col-md-12 mt-2">
                            <table class="table table-bordered table-hover" id="dt-ketercapaian">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center align-middle">No</th>
                                        <th scope="col" class="text-center align-middle">Nama Sekolah</th>
                                        <th scope="col" class="text-center align-middle">Tahun Ajaran</th>
                                        <th scope="col" class="text-center align-middle">Mata Pelajaran</th>
                                        <th scope="col" class="text-center align-middle">Materi</th>
                                        <th scope="col" class="text-center align-middle">Kelas</th>
                                        <th scope="col" class="text-center align-middle">Semester</th>
                                        <th scope="col" class="text-center align-middle">Nama Guru</th>
                                        <th scope="col" class="text-center align-middle">Aksi</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Info --}}
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Penjelasan Ketercapaian Tujuan & Kriteria Sukses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Sintaks keenam dari AFEL, Guru diminta untuk "membuat simpulan atas penilaian
                        yang sudah dilakukan," dengan ketentuan sebagai berikut :
                    </p>
                    <ol>
                        <li>Pada Menu Edit: ada 2 box yang harus diisi guru dalam bentuk tulisan,
                            yang berisikan: komentar guru atas ketercapaian tujuan + strategi
                            pembelajaran yang akan datang.</li>
                        <li>
                            Menu Download: berisikan tampilan portofolio dokumen:
                            <ul>
                                <li>Kisi-kisi</li>
                                <li>Rubrik</li>
                                <li>Soal & jawaban</li>
                                <li>Dokumentasi</li>
                                <li>Tabel Feedback</li>
                                <li>Tabel monitoring</li>
                                <li>Box ketercapaian</li>
                                <li>SURAKARTA, TANGGAL BULAN TAHUN (NAMA GURU)</li>
                            </ul>
                        </li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            load_table();

            $('#dt-ketercapaian').on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                const url = BASE_URL + 'ketercapaian-tujuan/edit/' + id;
                window.location.href = url;
            });
        });

        // List
        function load_table() {
            table = $('#dt-ketercapaian').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                language: dtLang,
                ajax: {
                    url: BASE_URL + 'ketercapaian-tujuan/data',
                    type: 'get',
                    dataType: 'json'
                },
                order: [
                    [9, 'desc']
                ],
                columnDefs: [{
                    targets: [0, -2],
                    searchable: false,
                    orderable: false,
                    className: 'text-center align-middle',
                }, {
                    targets: [1, 7],
                    className: 'text-left align-middle'
                }, {
                    targets: [2, 3, 4, 5, 6],
                    className: 'text-center align-middle'
                }, {
                    targets: [-1],
                    visible: false,
                }],
                columns: [{
                    data: 'DT_RowIndex'
                }, {
                    data: 'nama',
                }, {
                    data: 'tahun',
                }, {
                    data: 'matpel',
                }, {
                    data: 'materi_pelajaran',
                }, {
                    data: 'kelas',
                    render: function(data, type, row) {
                        return data + ' ' + row.kode_kelas;
                    }
                }, {
                    data: 'semester',
                }, {
                    data: 'nama_guru',
                }, {
                    data: 'encrypted_id',
                    render: (data, type, row) => {
                        const button_edit = $('<button>', {
                            class: 'btn btn-warning btn-edit',
                            html: '<i class="bx bxs-edit"></i> Edit',
                            'data-id': data,
                            title: 'Edit Ketercapaian',
                            'data-placement': 'top',
                            'data-toggle': 'tooltip'
                        });
                        const button_download = $('<button>', {
                            class: 'btn btn-primary btn-download',
                            html: '<i class="bx bxs-download"></i> Download Perangkat Penilaian',
                            'data-id': data,
                            title: 'Download Ketercapaian',
                            'data-placement': 'top',
                            'data-toggle': 'tooltip'
                        });

                        return $('<div>', {
                            class: 'btn-group',
                            html: () => {
                                let arr = [];
                                arr.push(button_edit)
                                arr.push(button_download)
                                return arr;
                            }
                        }).prop('outerHTML');
                    }
                }, {
                    data: 'created_at'
                }]
            })
        }

        // Download Ketercapaian
        $('#dt-ketercapaian').on('click', '.btn-download', function() {
            const id = $(this).data('id');
            window.location.href = BASE_URL + 'ketercapaian-tujuan/downloadKetercapaian/' + id;
        });

        // PieChart
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

                // Export To image
                chart.exporting.getImage("image/png").then(function(image) {
                    let link = document.createElement("a");
                    link.href = image.dataUri;
                    link.download = "pieChart.png";
                    link.click();
                });
            });
        }
    </script>
@endpush

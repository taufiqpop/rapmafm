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

    {{-- Feedback --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {{-- Button Info --}}
                    <div class="d-flex justify-content-end">
                        <div class="question-button" data-toggle="modal" data-target="#infoModal">
                            <i class="fas fa-question"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Feedback</h3>
                        </div>
                        <div class="col-md-12 mt-2">
                            <table class="table table-bordered table-hover" id="dt-feedback">
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
                    <h5 class="modal-title" id="infoModalLabel">Penjelasan Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Sintaks keempat dari AfEL, Guru diminta untuk ”feedback atau umpan balik” dalam bentuk
                        statement yang berisikan komentar guru atas skor akhir yang diperoleh peserta didik.
                        Guru memberikan feedback untuk setiap peserta didik, pada menu edit feedback.
                        Setelah guru memberikan feedback kepada seluruh peserta didik, maka guru dapat
                        mengakses menu download yang berisikan tampilan berikut ini.
                    </p>

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

            $('#dt-feedback').on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                const url = BASE_URL + 'feedback/edit/' + id;
                window.location.href = url;
            });
        });

        // List
        function load_table() {
            table = $('#dt-feedback').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                language: dtLang,
                ajax: {
                    url: BASE_URL + 'feedback/data',
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
                            title: 'Edit Feedback',
                            'data-placement': 'top',
                            'data-toggle': 'tooltip'
                        });
                        const button_download = $('<button>', {
                            class: 'btn btn-success btn-download',
                            html: '<i class="bx bxs-file-html"></i> Download',
                            'data-id': data,
                            title: 'Download Feedback',
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

        // Download Feedback
        $('#dt-feedback').on('click', '.btn-download', function() {
            const id = $(this).data('id');
            window.location.href = BASE_URL + 'feedback/downloadFeedback/' + id;
        });
    </script>
@endpush

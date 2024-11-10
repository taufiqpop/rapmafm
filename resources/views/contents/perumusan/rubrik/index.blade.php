@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

@push('styles')
    <style>
        .custom-number-input::-webkit-inner-spin-button,
        .custom-number-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .custom-number-input {
            -moz-appearance: textfield;
        }

        .input-custom:not(:focus) {
            outline: none !important;
            border: none !important;
            background-color: transparent !important;
            cursor: pointer;
        }

        .input-custom:focus {
            color: black !important;
            cursor: text;
        }

        .info-icon {
            cursor: pointer;
            margin-left: 5px;
            color: #007bff;
        }

        .tooltip.show {
            display: block;
        }

        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background: none;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 16px;
        }

        select::-ms-expand {
            display: none;
        }
    </style>
@endpush
@section('contents')
    {{-- Rubrik --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>
                                Data Rubrik - {{ $sekolah->nama }} ({{ $sekolah->kelas }} {{ $sekolah->kode_kelas }})
                            </h3>
                            <button class="btn btn-dark" onclick="history.back()">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </button>
                            <div class="float-right">
                                <label for="total-percentage" class="me-2">Total % :</label>
                                <input type="text" id="total-percentage" class="form-control" readonly
                                    style="display: inline-block; width: 80px;">
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <table class="table table-bordered table-hover" id="dt-rubrik">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center align-middle">No</th>
                                        <th scope="col" class="text-center align-middle">Ranah Penilaian</th>
                                        <th scope="col" class="text-center align-middle" style="max-width: 40px">
                                            Bobot
                                        </th>
                                        <th scope="col" class="text-center align-middle">Instrumen Penilaian</th>
                                        <th scope="col" class="text-center align-middle">Bentuk</th>
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
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            load_table();

            $('#dt-rubrik').on('click', '.btn-materi', function() {
                const id = $(this).data('id');
                const rowData = table.row($(this).parents('tr')).data();

                if (rowData.ranah_penilaian.match(/Kognitif/i)) {
                    window.location.href = BASE_URL + 'perumusan/rubrik/kognitif/' + id;
                } else if (rowData.ranah_penilaian.match(/Afektif/i)) {
                    window.location.href = BASE_URL + 'perumusan/rubrik/afektif/' + id;
                } else if (rowData.ranah_penilaian.match(/Psikomotorik/i)) {
                    window.location.href = BASE_URL + 'perumusan/rubrik/psikomotorik/' + id;
                }
            });
        });

        // List
        function load_table() {
            table = $('#dt-rubrik').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                language: dtLang,
                ajax: {
                    url: BASE_URL + 'perumusan/rubrik/data',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        sekolah_id: {{ $sekolah->id }}
                    }
                },
                order: [
                    [6, 'desc']
                ],
                columnDefs: [{
                    targets: [0, -2],
                    searchable: false,
                    orderable: false,
                    className: 'text-center align-middle',
                }, {
                    targets: [1, 4],
                    className: 'text-left align-middle'
                }, {
                    targets: [2, 3],
                    className: 'text-center align-middle'
                }, {
                    targets: [-1],
                    visible: false,
                }],
                columns: [{
                    data: 'DT_RowIndex'
                }, {
                    data: 'ranah_penilaian',
                }, {
                    data: 'bobot_penilaian',
                    render: (data, type, row) => {
                        let html =
                            `<center>
                            <div class="input-group">
                                <input readonly type="number" class="form-control custom-number-input input-custom" value="${data}">
                                <span class="input-group-text p-0" style="background: transparent; border: none;"><b>%</b></span>
                            </div>
                        </center>`
                        return html;
                    }
                }, {
                    data: 'instrumen_penilaian',
                }, {
                    data: 'bentuk',
                    render: (data, type, row) => {
                        let html = ''
                        let regex = new RegExp('Kognitif', 'i');
                        let regex2 = new RegExp('Afektif', 'i');
                        let regex3 = new RegExp('Psikomotorik', 'i');

                        let bentukInput =
                            `<input disabled type="text" class="form-control bentuk-lainnya" style="display: ${data === 'Lainnya' ? 'block' : 'none'}" value="${row.bentuk_lainnya ?? ''}">`;

                        if (regex.test(row.ranah_penilaian)) {
                            html = `<select disabled class='form-control select2 select-bentuk'>
                                <option value='' selected disabled>Pilih Bentuk</option>
                                <option value='Multiple Choice' ${data == 'Multiple Choice' ? 'selected' : ''}>Multiple Choice</option>
                                <option value='Essay' ${data == 'Essay' ? 'selected' : ''}>Essay</option>
                                <option value='Performance Test' ${data == 'Performance Test' ? 'selected' : ''}>Performance Test</option>
                                <option value='Lainnya' ${data == 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                                <option value='-' ${data == '-' ? 'selected' : ''}>-</option>
                            </select>` + bentukInput;
                        } else if (regex2.test(row.ranah_penilaian)) {
                            html = `<select disabled class='form-control select2 select-bentuk'>
                                <option value='' selected disabled>Pilih Bentuk</option>
                                <option value='Attitude Scale' ${data == 'Attitude Scale' ? 'selected' : ''}>Attitude Scale</option>
                                <option value='Lainnya' ${data == 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                                <option value='-' ${data == '-' ? 'selected' : ''}>-</option>
                            </select>` + bentukInput;
                        } else if (regex3.test(row.ranah_penilaian)) {
                            html = `<select disabled class='form-control select2 select-bentuk'>
                                <option value='' selected disabled>Pilih Bentuk</option>
                                <option value='Attitude Scale' ${data == 'Attitude Scale' ? 'selected' : ''}>Attitude Scale</option>
                                <option value='Lainnya' ${data == 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                                <option value='-' ${data == '-' ? 'selected' : ''}>-</option>
                            </select>` + bentukInput;
                        } else {
                            html = `<select disabled class='form-control select2 select-bentuk'>
                                <option value='' selected disabled>Pilih Bentuk</option>
                                <option value='Lainnya' ${data == 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                                <option value='-' ${data == '-' ? 'selected' : ''}>-</option>
                            </select>` + bentukInput;
                        }

                        return html;
                    }
                }, {
                    data: 'encrypted_id',
                    render: (data, type, row) => {
                        const button_materi_blueprint = $('<button>', {
                            class: 'btn btn-primary btn-materi',
                            html: '<i class="bx bx-log-in-circle"></i>',
                            'data-id': data,
                            title: 'Materi Rubrik',
                            'data-placement': 'top',
                            'data-toggle': 'tooltip'
                        });

                        const button_download = $('<button>', {
                            class: 'btn btn-success btn-download',
                            html: '<i class="bx bx-download"></i>',
                            'data-id': data,
                            title: 'Download Rubrik',
                            'data-placement': 'top',
                            'data-toggle': 'tooltip'
                        });

                        return $('<div>', {
                            class: 'btn-group',
                            html: () => {
                                let arr = [];

                                arr.push(button_materi_blueprint)
                                arr.push(button_download)

                                return arr;
                            }
                        }).prop('outerHTML');
                    }
                }, {
                    data: 'created_at'
                }],
                drawCallback: function(settings) {
                    updateTotalPercentage();
                    $('.select2').select2({
                        width: '100%'
                    });
                }
            })
        }

        // Download PDF Rubrik
        $('#dt-rubrik').on('click', '.btn-download', function() {
            const id = $(this).data('id');
            window.location.href = BASE_URL + 'perumusan/rubrik/download/' + id;
        });

        // Total Persentase
        function updateTotalPercentage() {
            let totalBobot = 0;

            table.rows().every(function() {
                const bobot = parseFloat(this.data().bobot_penilaian) || 0;
                totalBobot += bobot;
            });

            $('#total-percentage').val(totalBobot.toFixed(2) + '%');
        }
    </script>
@endpush

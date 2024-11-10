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
    {{-- Materi Rubrik (Afektif) --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row pr-4">
                        <div class="col-md-12">
                            <h3>Data Rubrik - {{ $blueprint->ranah_penilaian }}</h3>
                            <button class="btn btn-dark" onclick="history.back()">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </button>
                        </div>
                        <div class="col-md-12 mt-2" id="afektif">
                            <table class="table table-bordered table-hover" id="dt-materi-rubrik">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center align-middle" style="width: 5%">No</th>
                                        <th scope="col" class="text-center align-middle" style="width: 500px">
                                            Nama Siswa
                                        </th>
                                        <th scope="col" class="text-center align-middle" style="width: 150px">
                                            Receiving
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="Memberikan Perhatian pada pembelajaran ekonomi"></i>
                                        </th>
                                        <th scope="col" class="text-center align-middle" style="width: 150px">
                                            Responding
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="Melakukan partisipasi aktif pada pembelajaran ekonomi"></i>
                                        </th>
                                        <th scope="col" class="text-center align-middle" style="width: 150px">
                                            Valuing
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="Menampilkan sikap dan apresiasi positif pada pembelajaran ekonomi"></i>
                                        </th>
                                        <th scope="col" class="text-center align-middle" style="width: 150px">
                                            Organization
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="Menampilkan kemampuan mengorganisir dan bekerjasama pada pembelajaran ekonomi"></i>
                                        </th>
                                        <th scope="col" class="text-center align-middle" style="width: 150px">
                                            Characterization
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="Mewujudkan perilaku yang bernilai baik pada pembelajaran ekonomi"></i>
                                        </th>
                                        <th scope="col" class="text-center align-middle" style="width: 75px">Total</th>
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

            $('#dt-materi-rubrik').on('input', '.custom-number-input', function() {
                if ($(this).val() > 100) {
                    $(this).val(100);
                }
            });
        });

        function load_table() {
            table = $('#dt-materi-rubrik').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                language: dtLang,
                ajax: {
                    url: BASE_URL + 'perumusan/rubrik/materi',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        blueprint_id: {{ $blueprint->id }},
                    }
                },
                order: [
                    [8, 'desc']
                ],
                columnDefs: [{
                    targets: [0, -2, 2, 3, 4, 5, 6, 7],
                    searchable: false,
                    orderable: false,
                    className: 'text-center align-middle',
                }, {
                    targets: [1],
                    className: 'text-left align-middle'
                }, {
                    targets: [-1, -2],
                    visible: false,
                }],
                columns: [{
                    data: 'DT_RowIndex'
                }, {
                    data: 'nama_siswa',
                    render: (data, type, row) => {
                        let inputField =
                            `<input readonly type="text" class="form-control d-inline-block input-custom" style="width: calc(100% - 40px);" value="${data}" data-tabel="materi_blueprint" data-id="${row.id}" data-kolom="nama_siswa" onchange="update_custom(this)">`;

                        return `<div class="btn-group w-100">
                    ${inputField}
                </div>`;
                    }
                }, {
                    data: 'indikator',
                    render: (data, type, row) => {
                        let html = '<ul class="list-unstyled">';
                        data.forEach(value => {
                            html +=
                                `<center>
                                <li>
                                    <input ${value.ra_receiving == 0 || value.ra_receiving == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.ra_receiving == 0 || value.ra_receiving == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.ra_receiving_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="ra_receiving_rubrik" id="ra_receiving_rubrik" onchange="update_custom(this)" oninput="totalAfektifRubrik(this)">
                                </li>
                            </center>`;
                        });
                        html += '</ul>';
                        return html;
                    }
                }, {
                    data: 'indikator',
                    render: (data, type, row) => {
                        let html = '<ul class="list-unstyled">';
                        data.forEach(value => {
                            html +=
                                `<center>
                                <li>
                                    <input ${value.ra_responding == 0 || value.ra_responding == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.ra_responding == 0 || value.ra_responding == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.ra_responding_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="ra_responding_rubrik" id="ra_responding_rubrik" onchange="update_custom(this)" oninput="totalAfektifRubrik(this)">
                                </li>
                            </center>`;
                        });
                        html += '</ul>';
                        return html;
                    }
                }, {
                    data: 'indikator',
                    render: (data, type, row) => {
                        let html = '<ul class="list-unstyled">';
                        data.forEach(value => {
                            html +=
                                `<center>
                                <li>
                                    <input ${value.ra_valuing == 0 || value.ra_valuing == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.ra_valuing == 0 || value.ra_valuing == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.ra_valuing_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="ra_valuing_rubrik" id="ra_valuing_rubrik" onchange="update_custom(this)" oninput="totalAfektifRubrik(this)">
                                </li>
                            </center>`;
                        });
                        html += '</ul>';
                        return html;
                    }
                }, {
                    data: 'indikator',
                    render: (data, type, row) => {
                        let html = '<ul class="list-unstyled">';
                        data.forEach(value => {
                            html +=
                                `<center>
                                <li>
                                    <input ${value.ra_organization == 0 || value.ra_organization == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.ra_organization == 0 || value.ra_organization == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.ra_organization_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="ra_organization_rubrik" id="ra_organization_rubrik" onchange="update_custom(this)" oninput="totalAfektifRubrik(this)">
                                </li>
                            </center>`;
                        });
                        html += '</ul>';
                        return html;
                    }
                }, {
                    data: 'indikator',
                    render: (data, type, row) => {
                        let html = '<ul class="list-unstyled">';
                        data.forEach(value => {
                            html +=
                                `<center>
                                <li>
                                    <input ${value.ra_characterization == 0 || value.ra_characterization == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.ra_characterization == 0 || value.ra_characterization == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.ra_characterization_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="ra_characterization_rubrik" id="ra_characterization_rubrik" onchange="update_custom(this)" oninput="totalAfektifRubrik(this)">
                                </li>
                            </center>`;
                        });
                        html += '</ul>';
                        return html;
                    }
                }, {
                    data: 'indikator',
                    render: (data, type, row) => {
                        let html = '<ul class="list-unstyled">';
                        data.forEach(value => {
                            html +=
                                `<center>
                                <li>
                                    <input ${value.total_afektif_rubrik == 0 || value.total_afektif_rubrik == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.total_afektif_rubrik == 0 || value.total_afektif_rubrik == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.total_afektif_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="total_afektif_rubrik" id="total_afektif_rubrik" onchange="update_custom(this)" oninput="totalAfektifRubrik(this)">
                                </li>
                            </center>`
                        })
                        html += '</ul>'
                        return html;
                    }
                }, {
                    data: 'id',
                }, {
                    data: 'created_at'
                }]
            })
        }

        // Total Afektif Rubrik
        function totalAfektifRubrik(element) {
            let rowId = $(element).data('id');

            let receiving = parseFloat($(`input[data-id='${rowId}'][data-kolom='ra_receiving_rubrik']`).val()) || 0;
            let responding = parseFloat($(`input[data-id='${rowId}'][data-kolom='ra_responding_rubrik']`).val()) || 0;
            let valuing = parseFloat($(`input[data-id='${rowId}'][data-kolom='ra_valuing_rubrik']`).val()) || 0;
            let organization = parseFloat($(`input[data-id='${rowId}'][data-kolom='ra_organization_rubrik']`).val()) || 0;
            let characterization = parseFloat($(`input[data-id='${rowId}'][data-kolom='ra_characterization_rubrik']`)
                .val()) || 0;

            let total = receiving + responding + valuing + organization + characterization;

            if (total > 100) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Total Kognitif Tidak Bisa Lebih Dari 100',
                    text: 'Silahkan Masukkan Data Yang Sesuai, Jika Tidak Maka Totalnya Akan Tetap 0.',
                    confirmButtonText: 'OK'
                });

                total = 0;
            }

            $(`input[data-id='${rowId}'][data-kolom='total_afektif_rubrik']`).val(total);

            update_custom($(`input[data-id='${rowId}'][data-kolom='total_afektif_rubrik']`)[0], false);
        }

        // Autosave (Upate Custom)
        function update_custom(ctx) {
            let id = $(ctx).data('id');
            let tabel = $(ctx).data('tabel');
            let kolom = $(ctx).data('kolom');
            let value = null;

            $.ajax({
                type: "POST",
                url: "{{ route('blueprint.update_custom') }}",
                data: {
                    id: id,
                    tabel: tabel,
                    kolom: kolom ?? $(ctx).prop('name'),
                    value: value ?? $(ctx).val(),
                },
                dataType: "JSON",
            }).then(res => {
                if (res.status) {
                    toastr.success(res.message, 'Sukses')
                    // table.ajax.reload();
                }
            })
        }
    </script>
@endpush

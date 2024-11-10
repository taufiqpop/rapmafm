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
    {{-- Materi Rubrik (Psikomotorik) --}}
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
                        <div class="col-md-12 mt-2" id="psikomotorik">
                            <table class="table table-bordered table-hover" id="dt-materi-rubrik">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center align-middle" style="width: 5%">No</th>
                                        <th scope="col" class="text-center align-middle" style="width: 500px">
                                            Nama Siswa
                                        </th>
                                        <th scope="col" class="text-center align-middle" style="width: 150px">
                                            Imitation
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="menirukan stimulus (menyalin, mengikuti, mengulangi, dll)"></i>
                                        </th>
                                        <th scope="col" class="text-center align-middle" style="width: 150px">
                                            Manipulation
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="menyiapkan diri secara fisik dalam bentuk menerapkan, mempersiapkan, mempertunjukkan, dll"></i>
                                        </th>
                                        <th scope="col" class="text-center align-middle" style="width: 150px">
                                            Precision
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="Menghasilkan ketepatam (mempraktikkan dengan tepat, memposisikan dengan tepat, dll)"></i>
                                        </th>
                                        <th scope="col" class="text-center align-middle" style="width: 150px">
                                            Articulation
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="Mengaitkan beberapa keterampilan fisik (mengintegrasikan, merangkaikan, dll)"></i>
                                        </th>
                                        <th scope="col" class="text-center align-middle" style="width: 150px">
                                            Naturalisation
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="Menghasilkan karya cipta dengan ketepatan yang tinggi"></i>
                                        </th>
                                        <th scope="col" class="text-center align-middle" style="width: 75px">Total
                                        </th>
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
                                    <input ${value.rp_imitation == 0 || value.rp_imitation == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.rp_imitation == 0 || value.rp_imitation == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.rp_imitation_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rp_imitation_rubrik" id="rp_imitation_rubrik" onchange="update_custom(this)" oninput="totalPsikomotorikRubrik(this)">
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
                                    <input ${value.rp_manipulation == 0 || value.rp_manipulation == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.rp_manipulation == 0 || value.rp_manipulation == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.rp_manipulation_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rp_manipulation_rubrik" id="rp_manipulation_rubrik" onchange="update_custom(this)" oninput="totalPsikomotorikRubrik(this)">
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
                                    <input ${value.rp_precision == 0 || value.rp_precision == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.rp_precision == 0 || value.rp_precision == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.rp_precision_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rp_precision_rubrik" id="rp_precision_rubrik" onchange="update_custom(this)" oninput="totalPsikomotorikRubrik(this)">
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
                                    <input ${value.rp_articulation == 0 || value.rp_articulation == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.rp_articulation == 0 || value.rp_articulation == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.rp_articulation_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rp_articulation_rubrik" id="rp_articulation_rubrik" onchange="update_custom(this)" oninput="totalPsikomotorikRubrik(this)">
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
                                    <input ${value.rp_naturalisation == 0 || value.rp_naturalisation == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.rp_naturalisation == 0 || value.rp_naturalisation == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.rp_naturalisation_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rp_naturalisation_rubrik" id="rp_naturalisation_rubrik" onchange="update_custom(this)" oninput="totalPsikomotorikRubrik(this)">
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
                                    <input ${value.total_psikomotorik_rubrik == 0 || value.total_psikomotorik_rubrik == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.total_psikomotorik_rubrik == 0 || value.total_psikomotorik_rubrik == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.total_psikomotorik_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="total_psikomotorik_rubrik" id="total_psikomotorik_rubrik" onchange="update_custom(this)" oninput="totalPsikomotorikRubrik(this)">
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

        // Total Psikomotorik Rubrik
        function totalPsikomotorikRubrik(element) {
            let rowId = $(element).data('id');

            let imitation = parseFloat($(`input[data-id='${rowId}'][data-kolom='rp_imitation_rubrik']`).val()) || 0;
            let manipulation = parseFloat($(`input[data-id='${rowId}'][data-kolom='rp_manipulation_rubrik']`).val()) || 0;
            let precision = parseFloat($(`input[data-id='${rowId}'][data-kolom='rp_precision_rubrik']`).val()) || 0;
            let articulation = parseFloat($(`input[data-id='${rowId}'][data-kolom='rp_articulation_rubrik']`).val()) || 0;
            let naturalisation = parseFloat($(`input[data-id='${rowId}'][data-kolom='rp_naturalisation_rubrik']`)
                .val()) || 0;

            let total = imitation + manipulation + precision + articulation + naturalisation;

            if (total > 100) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Total Kognitif Tidak Bisa Lebih Dari 100',
                    text: 'Silahkan Masukkan Data Yang Sesuai, Jika Tidak Maka Totalnya Akan Tetap 0.',
                    confirmButtonText: 'OK'
                });

                total = 0;
            }

            $(`input[data-id='${rowId}'][data-kolom='total_psikomotorik_rubrik']`).val(total);

            update_custom($(`input[data-id='${rowId}'][data-kolom='total_psikomotorik_rubrik']`)[0], false);
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

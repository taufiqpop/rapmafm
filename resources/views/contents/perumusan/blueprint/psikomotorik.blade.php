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
    {{-- Materi Blueprint (Psikomotorik) --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row pr-4">
                        <div class="col-md-12">
                            <h3>Data Kisi-Kisi - {{ $blueprint->ranah_penilaian }}</h3>
                            <button class="btn btn-dark" onclick="history.back()">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </button>
                        </div>
                        <div class="col-md-12 mt-2" id="psikomotorik">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dt-materi-blueprint2">
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
                            <div class="my-3">
                                <h5>
                                    - GURU DIMINTA UNTUK MEMBERIKAN CHECKLIST ”V” PADA MENU “IMITATION, MANIPULATION,
                                    PRECISION, ARTICULATION, NATURALISATION”.
                                    <br><br>
                                    - GURU DIBERIKAN KEBEBASAN, BOLEH MEMBERIKAN “V” SATU ATAUPUN LEBIH, ATAUPUN SEMUANYA DI
                                    “V” JUGA BOLEH.
                                </h5>
                            </div>
                            <button id="add-materi2" class="btn btn-success"><i class="bx bx-plus-circle"></i> Tambah
                                Siswa</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Template Form Materi Blueprint --}}
    <script type="text/template" id="materi-row-template3">
        <tr>
            <td class="text-center align-middle">#</td>
            <td class="text-left align-middle">
                <form action="{{ route('blueprint.materi_store') }}" method="post" id="form-materi2" class="form-materi2" autocomplete="off">
                    @csrf
                    <input type="hidden" name="blueprint_id" value="{{ $blueprint->id }}">
                    <input type="text" name="nama_siswa" class="form-control" placeholder="Masukkan Nama Siswa" required>
                    <div class="error-materi"></div>
                    <button type="button" class="btn btn-danger mt-2" onclick="deleteMateriRow2(this)"><i class="bx bx-trash"></i></button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light mt-2"><i class="bx bx-plus"></i></button>
                </form>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </script>

    {{-- Template Form Target Blueprint --}}
    <script type="text/template" id="target-row-template">
        <form action="{{ route('blueprint.target_store') }}" method="post" id="form-target" class="form-target" autocomplete="off">
            @csrf
            <li>
                <input type="text" name="materi_blueprint_id">
                <input type="text" name="target_pengetahuan" class="form-control" placeholder="Masukkan Indikator Pembelajaran">
                <button class="btn btn-danger mt-2" onclick="deleteTargetRow(this)"><i class="bx bx-trash"></i></button>
                <button type="submit" class="btn btn-primary waves-effect waves-light mt-2"><i class="bx bx-plus"></i></button>
            </li>
        </form>
    </script>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            load_table();

            $('#add-materi2').on('click', function() {
                addMateriRow2();
            });
        });

        function load_table() {
            table = $('#dt-materi-blueprint2').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                language: dtLang,
                ajax: {
                    url: BASE_URL + 'perumusan/blueprint/materi',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        blueprint_id: {{ $blueprint->id }},
                        materi_blueprint_id: sessionStorage.getItem('materi_blueprint_id')
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
                            `<input type="text" class="form-control d-inline-block input-custom" style="width: calc(100% - 40px);" value="${data}" data-tabel="materi_blueprint" data-id="${row.id}" data-kolom="nama_siswa" onchange="update_custom(this)">`;

                        const button_delete_materi = $('<button>', {
                            class: 'btn btn-danger btn-delete-materi d-inline-block',
                            html: '<i class="bx bx-trash"></i>',
                            'data-id': row.id,
                            title: 'Delete Materi',
                            'data-placement': 'top',
                            'data-toggle': 'tooltip',
                            style: 'width: 40px;'
                        });

                        let deleteButtonHtml = permissions.delete ? button_delete_materi.prop(
                            'outerHTML') : '';

                        return `<div class="btn-group w-100">
                    ${inputField}
                    ${deleteButtonHtml}
                </div>`;
                    }
                }, {
                    data: 'indikator',
                    render: (data, type, row) => {
                        let html = '<ul class="list-unstyled">';
                        data.forEach(value => {
                            html +=
                                `<li>
                                <center>
                                    <select class="form-control input-custom rp_imitation" style="width: 40px;" value="${value.rp_imitation}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rp_imitation" id="rp_imitation" onchange="update_custom(this)" oninput="totalPsikomotorikBlueprint(this)">
                                        <option value="" selected disabled>-</option>
                                        <option value="1" ${value.rp_imitation == 1 ? 'selected' : ''}>✔</option>
                                        <option value="0" ${value.rp_imitation == 0 ? 'selected' : ''}>✘</option>
                                    </select>
                                </center>
                            </li>`;
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
                                `<li>
                                <center>
                                    <select class="form-control input-custom rp_manipulation" style="width: 40px;" value="${value.rp_manipulation}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rp_manipulation" id="rp_manipulation" onchange="update_custom(this)" oninput="totalPsikomotorikBlueprint(this)">
                                        <option value="" selected disabled>-</option>
                                        <option value="1" ${value.rp_manipulation == 1 ? 'selected' : ''}>✔</option>
                                        <option value="0" ${value.rp_manipulation == 0 ? 'selected' : ''}>✘</option>
                                    </select>
                                </center>
                            </li>`;
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
                                `<li>
                                <center>
                                    <select class="form-control input-custom rp_precision" style="width: 40px;" value="${value.rp_precision}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rp_precision" id="rp_precision" onchange="update_custom(this)" oninput="totalPsikomotorikBlueprint(this)">
                                        <option value="" selected disabled>-</option>
                                        <option value="1" ${value.rp_precision == 1 ? 'selected' : ''}>✔</option>
                                        <option value="0" ${value.rp_precision == 0 ? 'selected' : ''}>✘</option>
                                    </select>
                                </center>
                            </li>`;
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
                                `<li>
                                <center>
                                    <select class="form-control input-custom rp_articulation" style="width: 40px;" value="${value.rp_articulation}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rp_articulation" id="rp_articulation" onchange="update_custom(this)" oninput="totalPsikomotorikBlueprint(this)">
                                        <option value="" selected disabled>-</option>
                                        <option value="1" ${value.rp_articulation == 1 ? 'selected' : ''}>✔</option>
                                        <option value="0" ${value.rp_articulation == 0 ? 'selected' : ''}>✘</option>
                                    </select>
                                </center>
                            </li>`;
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
                                `<li>
                                <center>
                                    <select class="form-control input-custom rp_naturalisation" style="width: 40px;" value="${value.rp_naturalisation}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rp_naturalisation" id="rp_naturalisation" onchange="update_custom(this)" oninput="totalPsikomotorikBlueprint(this)">
                                        <option value="" selected disabled>-</option>
                                        <option value="1" ${value.rp_naturalisation == 1 ? 'selected' : ''}>✔</option>
                                        <option value="0" ${value.rp_naturalisation == 0 ? 'selected' : ''}>✘</option>
                                    </select>
                                </center>
                            </li>`;
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
                                    <input readonly type="number" class="form-control custom-number-input input-custom total_psikomotorik" style="width: 50px; font-weight: bold;" value="${value.total_psikomotorik}" data-tabel="indikator_blueprint" data-id="${value.id}" id="total_psikomotorik" data-kolom="total_psikomotorik" onchange="update_custom(this)">
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

        // Create Materi
        $(document).off('submit', '.form-materi2').on('submit', '.form-materi2', function(e) {
            e.preventDefault();

            let form = $(this);
            let data = new FormData(this);

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: (res) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Berhasil Menyimpan Data',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    table.ajax.reload();
                    form.closest('tr').remove();
                },
                error: ({
                    status,
                    responseJSON
                }) => {
                    if (status == 422) {
                        generateErrorMessage(responseJSON);
                        return false;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: responseJSON.msg,
                        showConfirmButton: true
                    });
                }
            });
        });

        // Delete Materi
        $('#dt-materi-blueprint2').on('click', '.btn-delete-materi', function() {
            let data = table.row($(this).closest('tr')).data();

            let {
                id,
                nama_siswa
            } = data;

            Swal.fire({
                title: 'Anda yakin?',
                html: `Anda akan menghapus nama siswa "<b>${nama_siswa}</b>"!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(BASE_URL + 'perumusan/blueprint/materi_delete', {
                        id,
                        _method: 'DELETE'
                    }).done((res) => {
                        showSuccessToastr('Sukses', 'Materi Kisi-Kisi berhasil dihapus');
                        table.ajax.reload();
                    }).fail((res) => {
                        let {
                            status,
                            responseJSON
                        } = res;
                        showErrorToastr('oops', responseJSON.message);
                    })
                }
            })
        })

        // Add Materi Row
        function addMateriRow2() {
            let materiRow = $('#materi-row-template3').html();
            $('#dt-materi-blueprint2 tbody').append(materiRow);
        }

        // Delete Materi Row
        function deleteMateriRow2(ctx) {
            Swal.fire({
                title: 'Apa anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(ctx).closest('tr').remove();
                    Swal.fire(
                        'Berhasil Dihapus!',
                        'Sukses',
                        'success'
                    );
                }
            });
        }

        // Total Psikomotorik Blueprint
        function totalPsikomotorikBlueprint(element) {
            let row = $(element).closest('tr');

            let imitation = parseFloat(row.find('.rp_imitation').val()) || 0;
            let manipulation = parseFloat(row.find('.rp_manipulation').val()) || 0;
            let precision = parseFloat(row.find('.rp_precision').val()) || 0;
            let articulation = parseFloat(row.find('.rp_articulation').val()) || 0;
            let naturalisation = parseFloat(row.find('.rp_naturalisation').val()) || 0;

            let total = imitation + manipulation + precision + articulation + naturalisation;
            row.find('.total_psikomotorik').val(total);

            update_custom(row.find('.total_psikomotorik'));
        }

        // Autosave
        function update_custom(ctx) {
            let id = $(ctx).data('id');
            let tabel = $(ctx).data('tabel');
            let kolom = $(ctx).data('kolom');
            let value = null;

            $.ajax({
                type: "POST",
                url: "{{ route('blueprint.update_custom') }}",
                data: {
                    id: id ?? '{{ $blueprint->id }}',
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

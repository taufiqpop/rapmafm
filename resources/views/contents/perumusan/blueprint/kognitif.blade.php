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
    {{-- Materi Blueprint (Kognitif) --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row pr-4">
                        <div class="col-md-6">
                            <h3>Data Kisi-Kisi - {{ $blueprint->ranah_penilaian }}</h3>
                            <button class="btn btn-dark" onclick="history.back()">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </button>
                        </div>
                        <div class="col-md-12 mt-2" id="kognitif">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dt-materi-blueprint">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center align-middle" style="width: 5%">No</th>
                                            <th scope="col" class="text-center align-middle" style="width: 400px">Materi
                                            </th>
                                            <th scope="col" class="text-center align-middle" style="width: 800px">
                                                Indikator Pembelajaran</th>
                                            <th scope="col" class="text-center align-middle" style="width: 110px">
                                                Remember
                                                <i class="fas fa-info-circle" data-toggle="tooltip"
                                                    title="Siswa dapat menyebutkan, mengidentifikasi, memenghafal, dan sejenisnya"></i>
                                            </th>
                                            <th scope="col" class="text-center align-middle" style="width: 110px">
                                                Understand
                                                <i class="fas fa-info-circle" data-toggle="tooltip"
                                                    title="Siswa dapat menjelaskan, merangkum, menggolongkan, dan sejenisnya"></i>
                                            </th>
                                            <th scope="col" class="text-center align-middle" style="width: 110px">
                                                Apply
                                                <i class="fas fa-info-circle" data-toggle="tooltip"
                                                    title="Siswa dapat menggambarkan, menerapkan, mengadaptasi, dan sejenisnya"></i>
                                            </th>
                                            <th scope="col" class="text-center align-middle" style="width: 110px">
                                                Analyze
                                                <i class="fas fa-info-circle" data-toggle="tooltip"
                                                    title="Siswa dapat memecahkan, mengaitkan, menganalisis, dan sejenisnya"></i>
                                            </th>
                                            <th scope="col" class="text-center align-middle" style="width: 110px">
                                                Evaluate
                                                <i class="fas fa-info-circle" data-toggle="tooltip"
                                                    title="Siswa dapat membandingkan, menafsirkan, memutuskan, dan sejenisnya"></i>
                                            </th>
                                            <th scope="col" class="text-center align-middle" style="width: 110px">
                                                Create
                                                <i class="fas fa-info-circle" data-toggle="tooltip"
                                                    title="Siswa dapat mengkreasikan, memproduksi, merancang, dan sejenisnya"></i>
                                            </th>
                                            <th scope="col" class="text-center align-middle" style="width: 110px">Total
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <button id="add-materi" class="btn btn-success"><i class="bx bx-plus-circle"></i> Tambah
                                Materi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Template Form Materi Blueprint --}}
    <script type="text/template" id="materi-row-template">
        <tr>
            <td class="text-center align-middle">#</td>
            <td class="text-left align-middle">
                <form action="{{ route('blueprint.materi_store') }}" method="post" id="form-materi" class="form-materi" autocomplete="off">
                    @csrf
                    <input type="hidden" name="blueprint_id" value="{{ $blueprint->id }}">
                    <textarea name="materi" class="form-control styled-textarea" placeholder="Masukkan Materi" required></textarea>
                    <div class="error-materi"></div>
                    <button type="button" class="btn btn-danger mt-2" onclick="deleteMateriRow(this)"><i class="bx bx-trash"></i></button>
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
                <input type="hidden" name="materi_blueprint_id" id="materi_blueprint_id">
                <textarea name="target_pengetahuan" class="form-control styled-textarea" placeholder="Masukkan Indikator Pembelajaran"></textarea>
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

            $('#add-materi').on('click', function() {
                addMateriRow();
            });

            $('#dt-materi-blueprint').on('click', '.btn-add-target', function() {
                addTargetRow(this);
            });

            $('#dt-materi-blueprint').on('input', '.custom-number-input', function() {
                if ($(this).val() > 100) {
                    $(this).val(100);
                }
            });
        });

        function load_table() {
            table = $('#dt-materi-blueprint').DataTable({
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
                    [10, 'asc']
                ],
                columnDefs: [{
                    targets: [0, -2, 3, 4, 5, 6, 7, 8, 9, 10],
                    searchable: false,
                    orderable: false,
                    className: 'text-center align-middle',
                }, {
                    targets: [2],
                    searchable: false,
                    orderable: false,
                    className: 'text-left align-middle'
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
                    data: 'materi',
                    render: (data, type, row) => {
                        let inputField =
                            `<textarea class="form-control d-inline-block input-custom styled-textarea" data-tabel="materi_blueprint" data-id="${row.id}" data-kolom="materi" onchange="update_custom(this)">${data}</textarea>`;

                        const button_delete_materi = $('<button>', {
                            class: 'btn btn-danger btn-delete-materi d-inline-block',
                            html: '<i class="bx bx-trash"></i>',
                            'data-id': row.id,
                            title: 'Delete Materi',
                            'data-placement': 'top',
                            'data-toggle': 'tooltip',
                            style: 'width: 40px;'
                        });

                        const button_add_target = $('<button>', {
                            class: 'btn btn-info btn-add-target d-inline-block',
                            html: '<i class="bx bx-plus"></i>',
                            'data-id': row.id,
                            title: 'Tambah Indikator',
                            'data-placement': 'top',
                            'data-toggle': 'tooltip',
                            style: 'width: 40px;'
                        });

                        let deleteButtonHtml = permissions.delete ? button_delete_materi.prop(
                            'outerHTML') : '';
                        let addTargetButtonHtml = permissions.create ? button_add_target.prop(
                            'outerHTML') : '';

                        return `<div class="btn-group w-100">
                        ${inputField}
                        ${deleteButtonHtml}
                        ${addTargetButtonHtml}
                    </div>`;
                    }
                }, {
                    data: 'indikator',
                    render: (data, type, row) => {
                        let html = '<ul>';
                        data.forEach(value => {
                            const button_delete_indikator = $('<button>', {
                                class: 'btn btn-danger btn-delete-indikator d-inline-block',
                                html: '<i class="bx bx-trash"></i>',
                                'data-id': value.id,
                                'data-target_pengetahuan': value.target_pengetahuan,
                                title: 'Delete Indikator',
                                'data-placement': 'top',
                                'data-toggle': 'tooltip',
                                style: 'width: 40px;'
                            });

                            let deleteIndikatorButtonHtml = permissions.delete ?
                                button_delete_indikator.prop('outerHTML') : '';

                            html += `<li>
                                        <textarea class="form-control d-inline-block input-custom styled-textarea" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="target_pengetahuan" onchange="update_custom(this)">${value.target_pengetahuan}</textarea>
                                        ${deleteIndikatorButtonHtml}
                                        </li>
                                    <hr>`
                        });
                        html += '</ul>'
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
                                    <input type="number" class="form-control custom-number-input input-custom" style="width: 50px; font-weight: bold;" value="${value.rk_remember}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rk_remember" id="rk_remember" onchange="update_custom(this)" oninput="totalKognitifBlueprint(this)">
                                </li>
                                <hr>
                            </center>`
                        })
                        html += '</ul>'
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
                                    <input type="number" class="form-control custom-number-input input-custom" style="width: 50px; font-weight: bold;" value="${value.rk_understand}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rk_understand" id="rk_understand" onchange="update_custom(this)" oninput="totalKognitifBlueprint(this)">
                                </li>
                                <hr>
                            </center>`
                        })
                        html += '</ul>'
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
                                    <input type="number" class="form-control custom-number-input input-custom" style="width: 50px; font-weight: bold;" value="${value.rk_apply}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rk_apply" id="rk_apply" onchange="update_custom(this)" oninput="totalKognitifBlueprint(this)">
                                </li>
                                <hr>
                            </center>`
                        })
                        html += '</ul>'
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
                                    <input type="number" class="form-control custom-number-input input-custom" style="width: 50px; font-weight: bold;" value="${value.rk_analyze}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rk_analyze" id="rk_analyze" onchange="update_custom(this)" oninput="totalKognitifBlueprint(this)">
                                </li>
                                <hr>
                            </center>`
                        })
                        html += '</ul>'
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
                                    <input type="number" class="form-control custom-number-input input-custom" style="width: 50px; font-weight: bold;" value="${value.rk_evaluate}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rk_evaluate" id="rk_evaluate" onchange="update_custom(this)" oninput="totalKognitifBlueprint(this)">
                                </li>
                                <hr>
                            </center>`
                        })
                        html += '</ul>'
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
                                    <input type="number" class="form-control custom-number-input input-custom" style="width: 50px; font-weight: bold;" value="${value.rk_create}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rk_create" id="rk_create" onchange="update_custom(this)" oninput="totalKognitifBlueprint(this)">
                                </li>
                                <hr>
                            </center>`
                        })
                        html += '</ul>'
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
                                    <input readonly type="number" class="form-control custom-number-input input-custom" style="width: 50px; font-weight: bold;" value="${value.total_kognitif}" data-tabel="indikator_blueprint" data-id="${value.id}" id="total_kognitif" data-kolom="total_kognitif" onchange="update_custom(this)">
                                </li>
                                <hr>
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
        $(document).off('submit', '.form-materi').on('submit', '.form-materi', function(e) {
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
        $('#dt-materi-blueprint').on('click', '.btn-delete-materi', function() {
            let data = table.row($(this).closest('tr')).data();

            let {
                id,
                materi
            } = data;

            Swal.fire({
                title: 'Anda yakin?',
                html: `Anda akan menghapus blueprint "<b>${materi}</b>"!`,
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
        function addMateriRow() {
            let materiRow = $('#materi-row-template').html();
            $('#dt-materi-blueprint tbody').append(materiRow);
        }

        // Delete Materi Row
        function deleteMateriRow(ctx) {
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

        // Create Target
        $(document).off('submit', '.form-target').on('submit', '.form-target', function(e) {

            let tr = $(this).closest('tr');
            let tableData = table.row(tr).data();
            const {
                id
            } = tableData;

            e.preventDefault();

            let form = $(this);
            let data = new FormData(this);

            data.append('materi_blueprint_id', id)

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

        // Delete Indikator
        $('#dt-materi-blueprint').on('click', '.btn-delete-indikator', function() {
            let id = $(this).data('id');
            let target_pengetahuan = $(this).data('target_pengetahuan');

            Swal.fire({
                title: 'Anda yakin?',
                html: `Anda akan menghapus "<b>${target_pengetahuan}</b>"!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(BASE_URL + 'perumusan/blueprint/target_delete', {
                        id,
                        _method: 'DELETE'
                    }).done((res) => {
                        showSuccessToastr('Sukses', 'Indikator Kisi-Kisi berhasil dihapus');
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

        // Add Target Row
        function addTargetRow(ctx) {
            let targetRow = $('#target-row-template').html();
            $(ctx).closest('td').siblings().eq(1).find('ul').append(targetRow);
        }

        // Delete Target Row
        function deleteTargetRow(ctx) {
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
                    $(ctx).closest('li').remove();
                    Swal.fire(
                        'Berhasil Dihapus!',
                        'Sukses',
                        'success'
                    );
                }
            });
        }

        // Total Kognitif Blueprint
        function totalKognitifBlueprint(element) {
            let rowId = $(element).data('id');

            let remember = parseFloat($(`input[data-id='${rowId}'][data-kolom='rk_remember']`).val()) || 0;
            let understand = parseFloat($(`input[data-id='${rowId}'][data-kolom='rk_understand']`).val()) || 0;
            let apply = parseFloat($(`input[data-id='${rowId}'][data-kolom='rk_apply']`).val()) || 0;
            let analyze = parseFloat($(`input[data-id='${rowId}'][data-kolom='rk_analyze']`).val()) || 0;
            let evaluate = parseFloat($(`input[data-id='${rowId}'][data-kolom='rk_evaluate']`).val()) || 0;
            let create = parseFloat($(`input[data-id='${rowId}'][data-kolom='rk_create']`).val()) || 0;

            let total = remember + understand + apply + analyze + evaluate + create;

            if (total > 100) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Total Kognitif Tidak Bisa Lebih Dari 100',
                    text: 'Silahkan Masukkan Data Yang Sesuai, Jika Tidak Maka Totalnya Akan Tetap 0.',
                    confirmButtonText: 'OK'
                });

                total = 0;
            }

            $(`input[data-id='${rowId}'][data-kolom='total_kognitif']`).val(total);

            update_custom($(`input[data-id='${rowId}'][data-kolom='total_kognitif']`)[0], false);
        }

        // Autosave (Update Custom)
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

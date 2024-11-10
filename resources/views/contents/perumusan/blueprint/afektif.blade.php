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
    {{-- Materi Blueprint (Afektif) --}}
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
                        <div class="col-md-12 mt-2" id="afektif">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dt-materi-blueprint2">
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
                                            <th scope="col" class="text-center align-middle" style="width: 75px">Total
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <h5>- GURU DIMINTA UNTUK MEMBERIKAN CHECKLIST ”V” PADA MENU “RECEIVING, RESPONDING, VALUING,
                                ORGANIZATION,
                                CHARACTERIZATION”.
                                <br>
                                - GURU DIBERIKAN KEBEBASAN, BOLEH MEMBERIKAN “V” SATU ATAUPUN LEBIH, ATAUPUN SEMUANYA DI
                                “V” JUGA BOLEH.
                            </h5>
                            <button id="add-materi2" class="btn btn-success"><i class="bx bx-plus-circle"></i> Tambah
                                Siswa</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Template Form Materi Blueprint --}}
    <script type="text/template" id="materi-row-template2">
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
                                    <select class="form-control input-custom ra_receiving" style="width: 40px;" value="${value.ra_receiving}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="ra_receiving" id="ra_receiving" onchange="update_custom(this)" oninput="totalAfektifBlueprint(this)">
                                        <option value="" selected disabled>-</option>
                                        <option value="1" ${value.ra_receiving == 1 ? 'selected' : ''}>✔</option>
                                        <option value="0" ${value.ra_receiving == 0 ? 'selected' : ''}>✘</option>
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
                                    <select class="form-control input-custom ra_responding" style="width: 40px;" value="${value.ra_responding}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="ra_responding" id="ra_responding" onchange="update_custom(this)" oninput="totalAfektifBlueprint(this)">
                                        <option value="" selected disabled>-</option>
                                        <option value="1" ${value.ra_responding == 1 ? 'selected' : ''}>✔</option>
                                        <option value="0" ${value.ra_responding == 0 ? 'selected' : ''}>✘</option>
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
                                    <select class="form-control input-custom ra_valuing" style="width: 40px;" value="${value.ra_valuing}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="ra_valuing" id="ra_valuing" onchange="update_custom(this)" oninput="totalAfektifBlueprint(this)">
                                        <option value="" selected disabled>-</option>
                                        <option value="1" ${value.ra_valuing == 1 ? 'selected' : ''}>✔</option>
                                        <option value="0" ${value.ra_valuing == 0 ? 'selected' : ''}>✘</option>
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
                                    <select class="form-control input-custom ra_organization" style="width: 40px;" value="${value.ra_organization}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="ra_organization" id="ra_organization" onchange="update_custom(this)" oninput="totalAfektifBlueprint(this)">
                                        <option value="" selected disabled>-</option>
                                        <option value="1" ${value.ra_organization == 1 ? 'selected' : ''}>✔</option>
                                        <option value="0" ${value.ra_organization == 0 ? 'selected' : ''}>✘</option>
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
                                    <select class="form-control input-custom ra_characterization" style="width: 40px;" value="${value.ra_characterization}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="ra_characterization" id="ra_characterization" onchange="update_custom(this)" oninput="totalAfektifBlueprint(this)">
                                        <option value="" selected disabled>-</option>
                                        <option value="1" ${value.ra_characterization == 1 ? 'selected' : ''}>✔</option>
                                        <option value="0" ${value.ra_characterization == 0 ? 'selected' : ''}>✘</option>
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
                                    <input readonly type="number" class="form-control custom-number-input input-custom total_afektif" style="width: 50px; font-weight: bold;" value="${value.total_afektif}" data-tabel="indikator_blueprint" data-id="${value.id}" id="total_afektif" data-kolom="total_afektif" onchange="update_custom(this)">
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
            let materiRow = $('#materi-row-template2').html();
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

        // Total Afektif Blueprint
        function totalAfektifBlueprint(element) {
            let row = $(element).closest('tr');

            let receiving = parseFloat(row.find('.ra_receiving').val()) || 0;
            let responding = parseFloat(row.find('.ra_responding').val()) || 0;
            let valuing = parseFloat(row.find('.ra_valuing').val()) || 0;
            let organization = parseFloat(row.find('.ra_organization').val()) || 0;
            let characterization = parseFloat(row.find('.ra_characterization').val()) || 0;

            let total = receiving + responding + valuing + organization + characterization;
            row.find('.total_afektif').val(total);

            update_custom(row.find('.total_afektif'));
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

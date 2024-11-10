@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

@section('contents')
    {{-- Terminologi --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>{{ $title }}</h3>
                        </div>
                        <div class="col-md-12 mt-2">
                            @if (rbacCheck('terminologi', 2))
                                <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <div class="text-sm-right">
                                            <button type="button"
                                                class="btn btn-success btn-rounded waves-effect waves-light btn-tambah"><i
                                                    class="bx bx-plus-circle mr-1"></i> Tambah</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <table class="table table-bordered table-hover" id="dt-terminologi">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center align-middle">No</th>
                                        <th scope="col" class="text-center align-middle">Nama</th>
                                        <th scope="col" class="text-center align-middle" style="max-width: 40%">
                                            Deskripsi</th>
                                        <th scope="col" class="text-center align-middle">PDF</th>
                                        <th scope="col" class="text-center align-middle">Logo</th>
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

    {{-- Store --}}
    <div id="modal-terminologi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-terminologiLabel"
        aria-hidden="true">
        <form action="{{ route('terminologi.store') }}" method="post" id="form-terminologi" autocomplete="off">
            <div class="modal-dialog note-modal-content-large">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-terminologiLabel">Form Terminologi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Terminologi</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                placeholder="Masukkan Nama Terminologi">
                            <div id="error-nama"></div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" cols="10" rows="5"
                                placeholder="Masukkan Deskripsi"></textarea>
                            <div id="error-deskripsi"></div>
                        </div>
                        <div class="form-group">
                            <label for="nama_pdf">PDF</label>
                            <input type="file" name="nama_pdf" id="nama_pdf" class="form-control-file">
                            <div id="error-nama_pdf"></div>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" name="logo" id="logo" class="form-control-file">
                            <div id="error-logo"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Update --}}
    <div id="modal-terminologi-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-terminologi-updateLabel" aria-hidden="true">
        <form action="{{ route('terminologi.update') }}" method="post" id="form-terminologi-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-terminologi-updateLabel">Form Terminologi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="update-nama">Nama Terminologi</label>
                            <input type="text" name="nama" id="update-nama" class="form-control"
                                placeholder="Masukkan Nama Terminologi">
                            <div id="error-update-nama"></div>
                        </div>
                        <div class="form-group">
                            <label for="update-deskripsi">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="update-deskripsi" cols="10" rows="5"
                                placeholder="Masukkan Deskripsi"></textarea>
                            <div id="error-update-deskripsi"></div>
                        </div>
                        <div class="form-group">
                            <label for="update-nama_pdf">PDF</label>
                            <input type="file" name="nama_pdf" id="update-nama_pdf" class="form-control-file">
                            <div id="error-update-nama_pdf"></div>
                        </div>
                        <div class="form-group">
                            <label for="update-logo">Logo</label>
                            <input type="file" name="logo" id="update-logo" class="form-control-file">
                            <div id="error-update-logo"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- File PDF --}}
    <div id="modal-pdf" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-pdfLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-pdfLabel">Tampilan PDF</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdf-viewer" src="" style="width:100%; height:500px;" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- File Logo --}}
    <div id="modal-logo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-logoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-logoLabel">Tampilan Logo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <img id="logo-viewer" src="" class="img-fluid" alt="Logo">
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            load_table();
        });

        // List
        function load_table() {
            table = $('#dt-terminologi').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                language: dtLang,
                ajax: {
                    url: BASE_URL + 'terminologi/data',
                    type: 'get',
                    dataType: 'json'
                },
                order: [
                    [6, 'asc']
                ],
                columnDefs: [{
                    targets: [0, -2, 3, 4],
                    searchable: false,
                    orderable: false,
                    className: 'text-center align-middle',
                }, {
                    targets: [1, 2],
                    className: 'text-left align-middle'
                }, {
                    targets: [-1],
                    visible: false,
                }],
                columns: [{
                    data: 'DT_RowIndex'
                }, {
                    data: 'nama',
                }, {
                    data: 'deskripsi',
                }, {
                    data: 'nama_pdf',
                    render: (data, type, row) => {
                        return `<button class="btn btn-danger btn-pdf" data-pdf="${data}" title="Lihat PDF">
                        <i class="bx bxs-file-pdf"></i> Lihat PDF
                    </button>`;
                    }
                }, {
                    data: 'logo',
                    render: (data, type, row) => {
                        return `<button class="btn btn-info btn-logo" data-logo="${data}" title="Lihat Logo">
                                <i class="bx bx-image"></i> Lihat Logo
                            </button>`;
                    }
                }, {
                    data: 'id',
                    render: (data, type, row) => {
                        const button_edit = $('<button>', {
                            class: 'btn btn-warning btn-update',
                            html: '<i class="bx bx-pencil"></i>',
                            'data-id': data,
                            title: 'Update Data',
                            'data-placement': 'top',
                            'data-toggle': 'tooltip'
                        });

                        const button_delete = $('<button>', {
                            class: 'btn btn-danger btn-delete',
                            html: '<i class="bx bx-trash"></i>',
                            'data-id': data,
                            title: 'Delete Data',
                            'data-placement': 'top',
                            'data-toggle': 'tooltip'
                        });

                        return $('<div>', {
                            class: 'btn-group',
                            html: () => {
                                let arr = [];
                                if (permissions.update) arr.push(button_edit)
                                if (permissions.delete) arr.push(button_delete)

                                return arr;
                            }
                        }).prop('outerHTML');
                    }
                }, {
                    data: 'created_at'
                }]
            })
        }

        // Create
        $('#form-terminologi').on('submit', function(e) {
            e.preventDefault();

            let data = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: () => {
                    clearErrorMessage();
                    $('#modal-terminologi').find('.modal-dialog').LoadingOverlay('show');
                },
                success: (res) => {
                    $('#modal-terminologi').find('.modal-dialog').LoadingOverlay('hide', true);
                    $(this)[0].reset();
                    clearErrorMessage();
                    table.ajax.reload();
                    $('#modal-terminologi').modal('hide');
                },
                error: ({
                    status,
                    responseJSON
                }) => {
                    $('#modal-terminologi').find('.modal-dialog').LoadingOverlay('hide', true);

                    if (status == 422) {
                        generateErrorMessage(responseJSON);
                        return false;
                    }

                    showErrorToastr('oops', responseJSON.msg)
                }
            })
        })

        $('.btn-tambah').on('click', function() {
            $('#form-terminologi')[0].reset();
            clearErrorMessage();
            $('#modal-terminologi').modal('show');
        });

        // Update
        $('#form-terminologi-update').on('submit', function(e) {
            e.preventDefault();

            let data = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: () => {
                    clearErrorMessage();
                    $('#modal-terminologi-update').find('.modal-dialog').LoadingOverlay('show');
                },
                success: (res) => {
                    $('#modal-terminologi-update').find('.modal-dialog').LoadingOverlay('hide', true);
                    $(this)[0].reset();
                    clearErrorMessage();
                    table.ajax.reload();
                    $('#modal-terminologi-update').modal('hide');
                },
                error: ({
                    status,
                    responseJSON
                }) => {
                    $('#modal-terminologi-update').find('.modal-dialog').LoadingOverlay('hide', true);

                    if (status == 422) {
                        generateErrorMessage(responseJSON);
                        return false;
                    }

                    showErrorToastr('oops', responseJSON.msg)
                }
            })
        })

        $('#dt-terminologi').on('click', '.btn-update', function() {
            let tr = $(this).closest('tr');
            let data = table.row(tr).data();

            clearErrorMessage();
            $('#form-terminologi-update')[0].reset();

            $('#update-id').val(data.id);
            $('#update-nama').val(data.nama);
            $('#update-deskripsi').val(data.deskripsi);

            $('#update-nama_pdf').val('');
            $('#update-logo').val('');
            $('#error-update-nama_pdf').text('Silahkan Ubah File PDF');
            $('#error-update-logo').text('Silahkan Update Logo');

            $('#modal-terminologi-update').modal('show');
        });

        // Delete
        $('#dt-terminologi').on('click', '.btn-delete', function() {
            let data = table.row($(this).closest('tr')).data();

            let {
                id,
                nama
            } = data;

            Swal.fire({
                title: 'Anda yakin?',
                html: `Anda akan menghapus terminologi "<b>${nama}</b>"!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(BASE_URL + 'terminologi/delete', {
                        id,
                        _method: 'DELETE'
                    }).done((res) => {
                        showSuccessToastr('sukses', 'Terminologi berhasil dihapus');
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

        // Lihat PDF
        $('#dt-terminologi').on('click', '.btn-pdf', function() {
            const pdfUrl = `${BASE_URL}/storage/${$(this).data('pdf')}`;
            $('#pdf-viewer').attr('src', pdfUrl);
            $('#modal-pdf').modal('show');
        });

        // Lihat Logo
        $('#dt-terminologi').on('click', '.btn-logo', function() {
            const logoUrl = `${BASE_URL}storage/${$(this).data('logo')}`;
            $('#logo-viewer').attr('src', logoUrl);
            $('#modal-logo').modal('show');
        });
    </script>
@endpush

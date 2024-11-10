@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

@section('contents')
    {{-- Materi Mata Pelajaran --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>{{ $title }}</h3>
                        </div>
                        <div class="col-md-12 mt-2">
                            @if (rbacCheck('materi_matpel', 2))
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
                            <table class="table table-bordered table-hover" id="dt-materi_matpel">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center align-middle" style="width: 5%">No</th>
                                        <th scope="col" class="text-center align-middle">Nama Materi</th>
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
    <div id="modal-materi_matpel" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-materi_matpelLabel" aria-hidden="true">
        <form action="{{ route('materi_matpel.store') }}" method="post" id="form-materi_matpel" autocomplete="off">
            <div class="modal-dialog note-modal-content-large">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-materi_matpelLabel">Form Materi Mata Pelajaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_materi">Materi Mata Pelajaran</label>
                            <input type="text" name="nama_materi" id="nama_materi" class="form-control"
                                placeholder="Masukkan Materi Mata Pelajaran">
                            <div id="error-nama_materi"></div>
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
    <div id="modal-materi_matpel-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-materi_matpel-updateLabel" aria-hidden="true">
        <form action="{{ route('materi_matpel.update') }}" method="post" id="form-materi_matpel-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-materi_matpel-updateLabel">Form Materi Mata Pelajaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="update-nama_materi">Materi Mata Pelajaran</label>
                            <input type="text" name="nama_materi" id="update-nama_materi" class="form-control"
                                placeholder="Masukkan Materi Mata Pelajaran">
                            <div id="error-update-nama_materi"></div>
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
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            load_table();
        });

        // List
        function load_table() {
            table = $('#dt-materi_matpel').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                language: dtLang,
                ajax: {
                    url: BASE_URL + 'materi-matpel/data',
                    type: 'get',
                    dataType: 'json'
                },
                order: [
                    [3, 'asc']
                ],
                columnDefs: [{
                    targets: [0, -2],
                    searchable: false,
                    orderable: false,
                    className: 'text-center align-middle',
                }, {
                    targets: [1],
                    className: 'text-left align-middle'
                }, {
                    targets: [-1],
                    visible: false,
                }],
                columns: [{
                    data: 'DT_RowIndex'
                }, {
                    data: 'nama_materi',
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
        $('#form-materi_matpel').on('submit', function(e) {
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
                    $('#modal-materi_matpel').find('.modal-dialog').LoadingOverlay('show');
                },
                success: (res) => {
                    $('#modal-materi_matpel').find('.modal-dialog').LoadingOverlay('hide', true);
                    $(this)[0].reset();
                    clearErrorMessage();
                    showSuccessToastr('Sukses', 'Berhasil Menyimpan Data');
                    table.ajax.reload();
                    $('#modal-materi_matpel').modal('hide');
                },
                error: ({
                    status,
                    responseJSON
                }) => {
                    $('#modal-materi_matpel').find('.modal-dialog').LoadingOverlay('hide', true);

                    if (status === 422) {
                        const errors = responseJSON.errors;
                        let errorMessage = '';

                        Object.keys(errors).forEach((key) => {
                            errorMessage += errors[key].join('<br>') + '<br>';
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: errorMessage,
                            confirmButtonText: 'OK'
                        });

                        return false;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: responseJSON.msg,
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $('.btn-tambah').on('click', function() {
            $('#form-materi_matpel')[0].reset();
            clearErrorMessage();
            $('#modal-materi_matpel').modal('show');
        });

        // Update
        $('#form-materi_matpel-update').on('submit', function(e) {
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
                    $('#modal-materi_matpel-update').find('.modal-dialog').LoadingOverlay('show');
                },
                success: (res) => {
                    $('#modal-materi_matpel-update').find('.modal-dialog').LoadingOverlay('hide', true);
                    $(this)[0].reset();
                    clearErrorMessage();
                    showSuccessToastr('Sukses', 'Berhasil Mengubah Data');
                    table.ajax.reload();
                    $('#modal-materi_matpel-update').modal('hide');
                },
                error: ({
                    status,
                    responseJSON
                }) => {
                    $('#modal-materi_matpel-update').find('.modal-dialog').LoadingOverlay('hide', true);

                    if (status === 422) {
                        const errors = responseJSON.errors;
                        let errorMessage = '';

                        Object.keys(errors).forEach((key) => {
                            errorMessage += errors[key].join('<br>') + '<br>';
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: errorMessage,
                            confirmButtonText: 'OK'
                        });

                        return false;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: responseJSON.msg,
                        confirmButtonText: 'OK'
                    });
                }
            })
        })

        $('#dt-materi_matpel').on('click', '.btn-update', function() {
            let tr = $(this).closest('tr');
            let data = table.row(tr).data();

            clearErrorMessage();
            $('#form-materi_matpel-update')[0].reset();

            $.each(data, (key, value) => {
                $('#update-' + key).val(value).trigger('change');
            })

            $('#modal-materi_matpel-update').modal('show');
        })

        // Delete
        $('#dt-materi_matpel').on('click', '.btn-delete', function() {
            let data = table.row($(this).closest('tr')).data();

            let {
                id,
                nama_materi
            } = data;

            Swal.fire({
                title: 'Anda yakin?',
                html: `Anda akan menghapus "<b>${nama_materi}</b>"!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(BASE_URL + 'materi-matpel/delete', {
                        id,
                        _method: 'DELETE'
                    }).done((res) => {
                        showSuccessToastr('Sukses', 'Materi berhasil dihapus');
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
    </script>
@endpush

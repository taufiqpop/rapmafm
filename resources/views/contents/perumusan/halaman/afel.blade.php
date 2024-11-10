@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

{{-- Data Kelas --}}
<div class="row">
    <div class="col-md-6">
        <h3>Data Kelas</h3>
    </div>
    <div class="col-md-6 d-flex justify-content-end gap-4">
        <button type="button" class="btn btn-success btn-tambah-afel mr-1">
            <i class="bx bx-plus-circle"></i> Tambah Kelas
        </button>
        <button type="button" class="btn btn-dark btn-archive-afel" id="btn-archive-afel">
            <i class="bx bx-box"></i> Daftar Arsip
        </button>
    </div>
    <div class="col-md-12 mt-2">
        <table class="table table-bordered table-hover" id="dt-afel">
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

{{-- Store Modal AFEL --}}
<div id="modal-afel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-afelLabel"
    aria-hidden="true">
    <form action="{{ route('sekolah.store') }}" method="post" id="form-afel" autocomplete="off">
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="modal-afelLabel">Identitas Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- Nama Sekolah --}}
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama">Nama Sekolah<span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    placeholder="Masukkan Nama Sekolah" required>
                                <div id="error-nama"></div>
                            </div>
                        </div>

                        {{-- Tahun Ajaran --}}
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tahun">Tahun Ajaran<span class="text-danger">*</span></label>
                                <input type="text" name="tahun" id="tahun" class="form-control"
                                    placeholder="Masukkan Tahun" required>
                                <small>*Misalnya 2019 - 2020</small>
                                <div id="error-tahun"></div>
                            </div>
                        </div>

                        {{-- Semester --}}
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="semester">Semester<span class="text-danger">*</span></label>
                                <select name="semester" id="semester" class="form-control select2">
                                    <option value="" selected disabled>Pilih Semester</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                                <div id="error-semester"></div>
                            </div>
                        </div>

                        {{-- Mata Pelajaran --}}
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="matpel">Mata Pelajaran<span class="text-danger">*</span></label>
                                <select name="matpel" id="matpel" class="form-control select2">
                                    <option value="Ekonomi" selected>Ekonomi</option>
                                </select>
                                <small>*Hanya Ekonomi Saja</small>
                                <div id="error-matpel"></div>
                            </div>
                        </div>

                        {{-- Kelas --}}
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="kelas">Kelas<span class="text-danger">*</span></label>
                                <select name="kelas" id="kelas" class="form-control select2">
                                    <option value="" selected disabled>Pilih Kelas</option>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </select>
                                <div id="error-kelas"></div>
                            </div>
                        </div>

                        {{-- Kode Kelas --}}
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="kode_kelas">Kode Kelas<span class="text-danger">*</span></label>
                                <input type="text" name="kode_kelas" id="kode_kelas" class="form-control"
                                    placeholder="Masukkan Kode Kelas" required>
                                <small>*Misalnya Akuntansi IV</small>
                                <div id="error-kode_kelas"></div>
                            </div>
                        </div>

                        {{-- Materi Pelajaran --}}
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="materi_matpel_id">Materi Pelajaran<span
                                        class="text-danger">*</span></label>
                                <select name="materi_matpel_id[]" id="materi_matpel_id" class="form-control select2"
                                    multiple>
                                    @foreach ($materi_matpel as $materi)
                                        <option value="{{ $materi->id }}">{{ $materi->nama_materi }}</option>
                                    @endforeach
                                </select>
                                <small>*Bisa Pilih Lebih Dari Satu</small>
                                <div id="error-materi_matpel_id"></div>
                            </div>
                        </div>

                        {{-- Nama Guru --}}
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama_guru">Nama Guru<span class="text-danger">*</span></label>
                                <input type="text" name="nama_guru" id="nama_guru" class="form-control"
                                    placeholder="Masukkan Nama Guru (Dengan Gelar)" required>
                                <div id="error-nama_guru"></div>
                            </div>
                        </div>
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

{{-- Update Modal AFEL --}}
<div id="modal-afel-update" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="modal-afel-updateLabel" aria-hidden="true">
    <form action="{{ route('sekolah.update') }}" method="post" id="form-afel-update" autocomplete="off">
        <input type="hidden" name="id" id="update-id">
        @csrf
        @method('PATCH')
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="modal-afel-updateLabel">Identitas Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- Nama Sekolah --}}
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="update-nama">Nama Sekolah<span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="update-nama" class="form-control"
                                    placeholder="Masukkan Nama Sekolah" required>
                                <div id="error-update-nama"></div>
                            </div>
                        </div>

                        {{-- Tahun Ajaran --}}
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="update-tahun">Tahun Ajaran<span class="text-danger">*</span></label>
                                <input type="text" name="tahun" id="update-tahun" class="form-control"
                                    placeholder="Masukkan Tahun Ajaran" required>
                                <small>*Misalnya 2019 - 2020</small>
                                <div id="error-update-tahun"></div>
                            </div>
                        </div>

                        {{-- Semester --}}
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="update-semester">Semester<span class="text-danger">*</span></label>
                                <select name="semester" id="update-semester" class="form-control select2">
                                    <option value="" selected disabled>Pilih Semester</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                                <div id="error-update-semester"></div>
                            </div>
                        </div>

                        {{-- Mata Pelajaran --}}
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="update-matpel">Mata Pelajaran<span class="text-danger">*</span></label>
                                <select name="matpel" id="update-matpel" class="form-control select2">
                                    <option value="Ekonomi" selected>Ekonomi</option>
                                </select>
                                <small>*Hanya Ekonomi Saja</small>
                                <div id="error-update-matpel"></div>
                            </div>
                        </div>

                        {{-- Kelas --}}
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="update-kelas">Kelas<span class="text-danger">*</span></label>
                                <select name="kelas" id="update-kelas" class="form-control select2">
                                    <option value="" selected disabled>Pilih Kelas</option>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </select>
                                <div id="error-update-kelas"></div>
                            </div>
                        </div>

                        {{-- Kode Kelas --}}
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="update-kode_kelas">Kode Kelas<span class="text-danger">*</span></label>
                                <input type="text" name="kode_kelas" id="update-kode_kelas" class="form-control"
                                    placeholder="Masukkan Kode Kelas" required>
                                <small>*Misal Akuntansi IV</small>
                                <div id="error-update-kode_kelas"></div>
                            </div>
                        </div>

                        {{-- Materi Pelajaran --}}
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="update-materi_matpel_id">Materi Pelajaran<span
                                        class="text-danger">*</span></label>
                                <select name="materi_matpel_id[]" id="update-materi_matpel_id"
                                    class="form-control select2" multiple>
                                    @foreach ($materi_matpel as $materi)
                                        <option value="{{ $materi->id }}">{{ $materi->nama_materi }}</option>
                                    @endforeach
                                </select>
                                <small>*Bisa Pilih Lebih Dari Satu</small>
                                <div id="error-materi_matpel_id"></div>
                            </div>
                        </div>

                        {{-- Nama Guru --}}
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="update-nama_guru">Nama Guru<span class="text-danger">*</span></label>
                                <input type="text" name="nama_guru" id="update-nama_guru" class="form-control"
                                    placeholder="Masukkan Nama Guru" required>
                                <div id="error-update-nama_guru"></div>
                            </div>
                        </div>
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

{{-- Arsip Modal AFEL --}}
<div id="modal-afel-arsip" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-afel-arsipLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="modal-afel-arsipLabel">Data Arsip Sekolah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 mt-2">
                    <table class="table table-bordered table-hover w-100" id="dt-arsip">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        load_table();

        $('#btn-archive-afel').click(function() {
            load_arsip();
        });

        $('#dt-afel').on('click', '.btn-blueprint', function() {
            const id = $(this).data('id');
            const url = BASE_URL + 'perumusan/sekolah/blueprint/' + id;
            window.location.href = url;
        });

        $('#dt-afel').on('click', '.btn-rubrik', function() {
            const id = $(this).data('id');
            const url = BASE_URL + 'perumusan/sekolah/rubrik/' + id;
            window.location.href = url;
        });

        $('#modal-afel').on('shown.bs.modal', function() {
            $('#materi_matpel_id').select2({
                placeholder: 'Pilih Materi Pelajaran',
                allowClear: true,
                width: '100%'
            });
        });

        $('#modal-afel-update').on('shown.bs.modal', function() {
            $('#update-materi_matpel_id').select2({
                placeholder: 'Pilih Materi Pelajaran',
                allowClear: true,
                width: '100%'
            });
        });
    });

    // List
    function load_table() {
        table = $('#dt-afel').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            language: dtLang,
            ajax: {
                url: BASE_URL + 'perumusan/sekolah/data',
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
                    const button_blueprint = $('<button>', {
                        class: 'btn btn-primary btn-blueprint',
                        html: '<i class="bx bx-book"></i>',
                        'data-id': data,
                        title: 'Kisi-Kisi',
                        'data-placement': 'top',
                        'data-toggle': 'tooltip'
                    });

                    const button_rubrik = $('<button>', {
                        class: 'btn btn-info btn-rubrik',
                        html: '<i class="bx bx-cube"></i>',
                        'data-id': data,
                        title: 'Rubrik',
                        'data-placement': 'top',
                        'data-toggle': 'tooltip'
                    });

                    const button_edit = $('<button>', {
                        class: 'btn btn-warning btn-update',
                        html: '<i class="bx bx-pencil"></i>',
                        'data-id': data,
                        title: 'Update Data',
                        'data-placement': 'top',
                        'data-toggle': 'tooltip'
                    });

                    const button_arsip = $('<button>', {
                        class: 'btn btn-dark btn-arsip',
                        html: '<i class="bx bx-box"></i>',
                        'data-id': data,
                        title: 'Arsip Data',
                        'data-placement': 'top',
                        'data-toggle': 'tooltip'
                    });

                    return $('<div>', {
                        class: 'btn-group',
                        html: () => {
                            let arr = [];

                            arr.push(button_blueprint)
                            arr.push(button_rubrik)
                            if (permissions.update) {
                                arr.push(button_edit)
                            }
                            arr.push(button_arsip)

                            return arr;
                        }
                    }).prop('outerHTML');
                }
            }, {
                data: 'created_at'
            }],
            drawCallback: () => {
                $('.select2').select2({
                    width: '100%'
                })
            }
        })
    }

    // Create
    $('#form-afel').on('submit', function(e) {
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
                $('#modal-afel').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-afel').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                showSuccessToastr('Sukses', 'Berhasil Menyimpan Data');
                table.ajax.reload();
                $('#modal-afel').modal('hide');
            },
            error: ({
                status,
                responseJSON
            }) => {
                $('#modal-afel').find('.modal-dialog').LoadingOverlay('hide', true);

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

    $('.btn-tambah-afel').on('click', function() {
        $('#form-afel')[0].reset();
        clearErrorMessage();
        $('#modal-afel').modal('show');
    });

    // Update
    $('#form-afel-update').on('submit', function(e) {
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
                $('#modal-afel-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-afel-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                showSuccessToastr('Sukses', 'Berhasil Mengubah Data');
                table.ajax.reload();
                $('#modal-afel-update').modal('hide');
            },
            error: ({
                status,
                responseJSON
            }) => {
                $('#modal-afel-update').find('.modal-dialog').LoadingOverlay('hide', true);

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

    $('#dt-afel').on('click', '.btn-update', function() {
        let tr = $(this).closest('tr');
        let data = table.row(tr).data();

        clearErrorMessage();
        $('#form-afel-update')[0].reset();

        $.each(data, (key, value) => {
            $('#update-' + key).val(value).trigger('change');
        })

        $.ajax({
            url: BASE_URL + 'perumusan/sekolah/getSelectedMateriMatpel/' + data.encrypted_id,
            type: 'GET',
            success: function(response) {
                let selectedMateriMatpel = response.selected_materi_matpel_ids;
                $('#update-materi_matpel_id').val(selectedMateriMatpel).trigger('change');
            },
            error: function(xhr) {
                console.error('Failed to retrieve selected materi_matpel_ids:', xhr);
            }
        });

        $('#modal-afel-update').modal('show');
    })

    // Archive Button
    $('.btn-archive-afel').on('click', function() {
        clearErrorMessage();
        $('#modal-afel-arsip').modal('show');
    });

    // Archive
    $('#dt-afel').on('click', '.btn-arsip', function() {
        let data = table.row($(this).closest('tr')).data();

        let {
            id,
            nama
        } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan mengarsipkan "<b>${nama}</b>"!`,
            footer: 'Data yang diarsipkan dapat dilihat di Daftar Arsip!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Arsipkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'perumusan/sekolah/archive', {
                    id,
                    _method: 'PATCH'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Berhasil Mengarsipkan Data');
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

    // Unarchive
    function load_arsip() {
        table2 = $('#dt-arsip').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            language: dtLang,
            ajax: {
                url: BASE_URL + 'perumusan/sekolah/dataArsip',
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
                    const button_unarsip = $('<button>', {
                        class: 'btn btn-info btn-unarsip',
                        html: '<i class="bx bx-box"></i>',
                        'data-id': data,
                        title: 'Tampilkan Data',
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
                            arr.push(button_unarsip)
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

    $('#dt-arsip').on('click', '.btn-unarsip', function() {
        let data = table2.row($(this).closest('tr')).data();

        let {
            id,
            nama
        } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan Unarchive "<b>${nama}</b>"!`,
            footer: 'Data akan ditampilkan kembali!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Tampilkan Kembali!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'perumusan/sekolah/unarchive', {
                    id,
                    _method: 'PATCH'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Berhasil Unarsip Data');
                    table2.ajax.reload();
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

    // Delete Arsip
    $('#dt-arsip').on('click', '.btn-delete', function() {
        let data = table2.row($(this).closest('tr')).data();

        let {
            id,
            nama
        } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus "<b>${nama}</b>"!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'perumusan/sekolah/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Kelas berhasil dihapus');
                    table2.ajax.reload();
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

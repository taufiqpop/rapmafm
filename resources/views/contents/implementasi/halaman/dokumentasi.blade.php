@php
    $plugins = ['datatable', 'sweetalert'];
@endphp

<div class="row">
    <div class="col-md-6">
        <h3>Dokumentasi Penilaian</h3>
    </div>
    <div class="col-md-12 mt-2">
        <table class="table table-bordered table-hover" id="dt-dokumentasi">
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

{{-- Form Upload Dokumentasi --}}
<div id="modal-upload" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="label-modal-upload"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="label-modal-upload">Form Upload Dokumentasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('implementasi.uploadDokumentasi') }}" method="post" id="form-upload">
                    @csrf
                    <input type="hidden" name="sekolah_id" id="upload-sekolah_id" value="{{ $sekolah_id }}">
                    <div id="file-upload-container">
                        <div class="input-group mb-3 file-input-row">
                            <input type="file" name="dokumen[]" class="form-control">
                            <button type="button" class="btn btn-danger btn-remove-file"><i
                                    class="bx bx-trash"></i></button>
                        </div>
                        <small class="form-text text-muted mt-0 mb-2">
                            *File Harus Berupa Gambar (.jpg, .jpeg, .png) || Max 2 MB
                        </small>
                    </div>
                    <button type="button" class="btn btn-info" id="btn-add-file"><i class="bx bx-plus"></i> Tambah
                        File</button>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary waves-effect waves-light btn-submit"
                            form="form-upload"><i class="bx bx-upload"></i> Upload</button>
                    </div>
                </form>
                <table class="table table-bordered table-striped" id="file-table" style="width: 100%;">
                    <thead class="thead-dark">
                        <tr class="bg-blue">
                            <th style="width: 5%; text-align: center;">No</th>
                            <th style="width: 90%; text-align: left;">Nama File</th>
                            <th style="width: 5%; text-align: center;">Aksi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        load_table();
        load_table_dokumen();
    });

    // List
    function load_table() {
        table2 = $('#dt-dokumentasi').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            language: dtLang,
            ajax: {
                url: BASE_URL + 'implementasi/data',
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
                data: 'id',
                render: (data, type, row) => {
                    const hasDokumentasi = row.dokumentasi_exists;

                    const button_upload_dokumentasi = $('<button>', {
                        class: `btn ${hasDokumentasi ? 'btn-success' : 'btn-dark'} btn-upload-dokumentasi`,
                        html: '<i class="bx bx-upload"></i> Upload Dokumentasi<br><small>(Format .jpg / .jpeg / .png)</small>',
                        'data-id': data,
                        title: 'Upload Dokumentasi Penilaian',
                        'data-placement': 'top',
                        'data-toggle': 'tooltip'
                    });

                    return $('<div>', {
                        class: 'btn-group',
                        html: () => {
                            let arr = [];
                            arr.push(button_upload_dokumentasi)
                            return arr;
                        }
                    }).prop('outerHTML');
                }
            }, {
                data: 'created_at'
            }]
        });
    }

    // List Dokumentasi
    function load_table_dokumen() {
        let sekolahId = $('#upload-sekolah_id').val();
        table = $('#file-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            language: dtLang,
            ajax: {
                url: BASE_URL + 'implementasi/dataDokumentasi',
                type: 'get',
                dataType: 'json',
                data: function(d) {
                    d.sekolah_id = sekolahId;
                }
            },
            order: [
                [3, 'desc']
            ],
            columnDefs: [{
                targets: [0, 3],
                searchable: false,
                orderable: false,
                className: 'text-center align-middle',
            }, {
                targets: [3],
                visible: false,
            }],
            columns: [{
                data: 'DT_RowIndex'
            }, {
                data: 'nama_file',
            }, {
                data: "id",
                render: (id, type) => {
                    let button_delete = "",
                        button_show = "";

                    button_show = $("<button>", {
                        html: $("<i>", {
                            class: "bx bx-show",
                        }).prop("outerHTML"),
                        class: "btn btn-outline-primary btn-show",
                        "data-id": id,
                        "data-toggle": "tooltip",
                        "data-placement": "top",
                        title: "Lihat File",
                    });

                    button_delete = $("<button>", {
                        html: $("<i>", {
                            class: "bx bx-trash",
                        }).prop("outerHTML"),
                        class: "btn btn-outline-danger btn-delete",
                        "data-id": id,
                        "data-toggle": "tooltip",
                        "data-placement": "top",
                        title: "Hapus File",
                    });

                    return $("<div>", {
                        class: "btn-group",
                        html: [button_show, button_delete],
                    }).prop("outerHTML");
                },
            }, {
                data: 'created_at'
            }]
        })
    }

    // Button Upload Dokumentasi
    $(document).on('click', '.btn-upload-dokumentasi', function() {
        const sekolah_id = $(this).data('id');
        $('#upload-sekolah_id').val(sekolah_id);

        load_table_dokumen();
        $('#modal-upload').modal('show');
    });

    // Tambah Form Upload Dokumentasi
    $('#btn-add-file').click(function() {
        let newInputRow = `
            <div class="input-group mb-3 file-input-row">
                <input type="file" name="dokumen[]" class="form-control">
                <button type="button" class="btn btn-danger btn-remove-file"><i class="bx bx-trash"></i></button>
            </div>`;
        $('#file-upload-container').append(newInputRow);
    });

    // Upload Dokumentasi
    $('#form-upload').on('submit', function(event) {
        event.preventDefault();

        let isValid = true;

        $('input[type=file][name="dokumen[]"]').each(function(indexInArray, valueOfElement) {
            const fileInput = $(this)[0];
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileType = file.type;
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];

                if (!validTypes.includes(fileType)) {
                    isValid = false;
                    Swal.fire({
                        title: "Format file salah",
                        text: "Jenis file yang diunggah bukan jpg, jpeg, atau png",
                        icon: "error",
                        button: "OK"
                    });
                    return false;
                }

                const maxSize = 2 * 1024 * 1024;
                if (file.size > maxSize) {
                    isValid = false;
                    Swal.fire({
                        title: "Ukuran file terlalu besar",
                        text: "File yang diunggah tidak boleh lebih dari 2MB",
                        icon: "error",
                        button: "OK"
                    });
                    return false;
                }
            }
        });

        if (!isValid) {
            return;
        }

        let formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    title: "Success",
                    text: "File berhasil diunggah",
                    icon: "success",
                    button: "OK"
                });
                $('#modal-upload').modal('hide');
                table.ajax.reload();
                table2.ajax.reload();

                $('#file-upload-container').empty();
                $('#file-upload-container').append(`
                    <div class="input-group mb-3 file-input-row">
                        <input type="file" name="dokumen[]" class="form-control">
                        <button type="button" class="btn btn-danger btn-remove-file"><i class="bx bx-trash"></i></button>
                    </div>
                `);
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: "Error",
                    text: "An error occurred while uploading the files.",
                    icon: "error",
                    button: "OK"
                });
            }
        });
    });

    // Remove Form Upload
    $(document).on('click', '.btn-remove-file', function() {
        $(this).closest('.file-input-row').remove();
    });

    // Delete Dokumentasi
    $('#file-table').on('click', '.btn-delete', function() {
        let data = table.row($(this).closest('tr')).data();

        let {
            id
        } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus file ini !`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'implementasi/deleteDokumentasi', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('sukses', 'Dokumentasi Berhasil Dihapus!');
                    table.ajax.reload();
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

    // Lihat Dokumentasi
    $("#file-table").on("click", ".btn-show", function() {

        let tr = $(this).closest("tr");
        let data = table.row(tr).data();
        let {
            nama_file,
            path_file
        } = data;

        window.open(BASE_URL + 'storage/' + path_file, '_blank');
    });
</script>

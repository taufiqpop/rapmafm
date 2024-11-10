<div class="row">
    <div class="col-md-6">
        <h3>Hasil Penilaian Peserta Didik</h3>
    </div>
    <div class="col-md-12 mt-2">
        <table class="table table-bordered table-hover" id="dt-penilaian">
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

{{-- Import Excel --}}
<div id="modal-import-update" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="modal-import-updateLabel" aria-hidden="true">
    <form action="{{ route('implementasi.importExcel') }}" method="post" id="form-import-update" autocomplete="off"
        enctype="multipart/form-data">
        <input type="hidden" name="id" id="update-id">
        @csrf
        @method('PATCH')
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="modal-import-updateLabel">Form Import Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="uploadFileExcel">
                        <label for="file_excel">Pilih File Excel</label>
                        <input type="file" class="form-control-file" id="file_excel" name="file_excel" required>
                        <small class="form-text text-muted">File harus berformat .xlsx<br>
                            Data-Data Dalam File Excel Harus Berada Dalam Garis Border/Garis Tepi.
                        </small>
                    </div>
                    <div id="excel-content" class="mt-4" style="display: none;">
                        <h5>Preview Excel Content</h5>
                        <div id="excel-table"></div>
                        <button type="button" id="delete-excel" class="btn btn-danger mt-2"><i
                                class="bx bxs-trash"></i> Hapus File Excel</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Import</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Preview Data Excel --}}
<div id="modal-preview" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-previewLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="modal-previewLabel">Preview Penilaian Peserta Didik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" data-pattern="priority-columns">
                    <table class="table table-striped" id="table-penilaian" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th>Nama</th>
                                <th>Skor Kognitif</th>
                                <th>Skor Afektif</th>
                                <th>Skor Psikomotorik</th>
                                <th>Skor Akhir</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        load_table();
    });

    // List
    function load_table() {
        table = $('#dt-penilaian').DataTable({
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
                    const button_import = $('<button>', {
                        class: `btn ${row.file_excel != null ? 'btn-success' : 'btn-dark'} btn-import`,
                        html: '<i class="bx bx-upload"></i> Upload',
                        'data-id': data,
                        title: 'Upload Hasil Penilaian Peserta Didik',
                        'data-placement': 'top',
                        'data-toggle': 'tooltip'
                    });

                    const button_preview = $('<button>', {
                        class: `btn ${row.file_excel != null ? 'btn-info' : 'btn-dark'} btn-preview`,
                        html: '<i class="bx bx-file"></i> Preview',
                        'data-id': data,
                        title: 'Lihat Hasil Penghitungan Penilaian Peserta Didik',
                        'data-placement': 'top',
                        'data-toggle': 'tooltip',
                        disabled: row.file_excel != null ? false : true
                    });

                    const button_export = $(`<button>`, {
                        class: `btn ${row.file_excel != null ? 'btn-primary' : 'btn-dark'} btn-export`,
                        html: '<i class="bx bx-download"></i> Download',
                        'data-id': data,
                        title: 'Download Hasil Penilaian Peserta Didik',
                        'data-placement': 'top',
                        'data-toggle': 'tooltip',
                        disabled: row.file_excel != null ? false : true
                    });

                    return $('<div>', {
                        class: 'btn-group',
                        html: () => {
                            let arr = [];
                            arr.push(button_import)
                            arr.push(button_preview)
                            arr.push(button_export)
                            return arr;
                        }
                    }).prop('outerHTML');
                }
            }, {
                data: 'created_at'
            }]
        })
    }

    // Import Excel
    $('#form-import-update').on('submit', function(e) {
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
                $('#modal-import-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-import-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                showSuccessToastr('Sukses', 'Berhasil Mengubah Data');
                table.ajax.reload();
                $('#modal-import-update').modal('hide');
            },
            error: ({
                status,
                responseJSON
            }) => {
                $('#modal-import-update').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    // Button Import
    $('#dt-penilaian').on('click', '.btn-import', function() {
        let tr = $(this).closest('tr');
        let data = table.row(tr).data();

        clearErrorMessage();
        $('#form-import-update')[0].reset();

        $.each(data, (key, value) => {
            $('#update-' + key).val(value).trigger('change');
        });

        if (data.file_excel) {
            fetchExcelContent(data.file_excel);
            $('#excel-content').show();
            $('#uploadFileExcel').hide();
        } else {
            $('#excel-content').hide();
            $('#uploadFileExcel').show();
        }

        $('#modal-import-update').modal('show');
    });

    // Check File Max 2MB && .xls
    $('#uploadFileExcel').on('change', function(event) {
        const fileInput = event.target;
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const fileType = file.type;
            const maxSize = 2 * 1024 * 1024;
            const validTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-excel',
                'application/octet-stream'
            ];

            if (!validTypes.includes(fileType)) {
                Swal.fire({
                    title: "Format file salah",
                    text: "Hanya file Excel (.xls, .xlsx) yang diperbolehkan",
                    icon: "error",
                    button: "OK"
                });
                fileInput.value = '';
                return;
            }

            // Check file size
            if (file.size > maxSize) {
                Swal.fire({
                    title: "Ukuran file terlalu besar",
                    text: "File yang diunggah tidak boleh lebih dari 2MB",
                    icon: "error",
                    button: "OK"
                });
                fileInput.value = '';
                return;
            }
        }
    });

    // Button Preview
    $('#dt-penilaian').on('click', '.btn-preview', function() {
        let tr = $(this).closest('tr');
        let data = table.row(tr).data();

        clearErrorMessage();

        $.ajax({
            url: BASE_URL + 'implementasi/previewPenilaian',
            method: 'GET',
            data: {
                student_id: data.id
            },
            success: function(response) {
                if (response.status) {
                    $('#table-penilaian tbody').empty();

                    response.data.forEach(function(student, index) {
                        let row = `<tr>
                            <td>${index + 1}</td>
                            <td>${student.nama}</td>
                            <td>${student.skor_kognitif}</td>
                            <td>${student.skor_afektif}</td>
                            <td>${student.skor_psikomotorik}</td>
                            <td>${student.final_score}</td>
                        </tr>`;
                        $('#table-penilaian tbody').append(row);
                    });

                    $('#modal-preview').modal('show');
                } else {
                    console.error("No data found for the given student.");
                }
            },
        });
    });

    // Delete Excel
    $('#delete-excel').on('click', function() {
        Swal.fire({
            title: 'Anda Yakin?',
            text: "Anda akan menghapus file excel ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $('#update-id').val();

                $.ajax({
                    url: BASE_URL + 'implementasi/deleteExcel/' + id,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === true) {
                            Swal.fire('Deleted!', 'Your file has been deleted.', 'success');
                            $('#excel-content').hide();
                            $('#uploadFileExcel').show();
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error!', response.msg, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'Failed to delete the Excel file.', 'error');
                    }
                });
            }
        });
    });

    // Lihat Excel
    function fetchExcelContent(filePath) {
        $.ajax({
            url: BASE_URL + 'implementasi/fetchExcelContent',
            type: 'get',
            data: {
                file_excel: filePath
            },
            dataType: 'json',
            success: (res) => {
                $('#modal-import-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $('#form-import-update')[0].reset();
                clearErrorMessage();

                if (res.status) {
                    let tableContent = '<table class="table table-bordered text-center">';
                    const data = Object.values(res.data);

                    if (data.length > 0) {
                        tableContent += '<thead><tr>';
                        const headers = Object.keys(data[0]).slice(0, 5);
                        headers.forEach(header => {
                            tableContent += `<th>${header}</th>`;
                        });
                        tableContent += '</tr></thead>';

                        tableContent += '<tbody>';
                        data.forEach(row => {
                            tableContent += '<tr>';
                            headers.forEach(key => {
                                tableContent +=
                                    `<td class="align-middle">${row[key] || ''}</td>`;
                            });
                            tableContent += '</tr>';
                        });

                        tableContent += '</tbody></table>';
                    } else {
                        tableContent += '<tr><td colspan="4">No data found.</td></tr>';
                    }

                    $('#excel-table').html(tableContent);
                    $('#excel-content').show();
                } else {
                    $('#excel-table').html(
                        '<div class="alert alert-danger">Failed to load Excel content: ' + res.msg +
                        '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching Excel content:', error);
                $('#excel-table').html('<div class="alert alert-danger">Error fetching Excel content: ' +
                    error + '</div>');
            }
        });
    }

    // Download Penilaian
    $('#dt-penilaian').on('click', '.btn-export', function() {
        const id = $(this).data('id');
        window.location.href = BASE_URL + 'implementasi/downloadPenilaian/' + id;
    });
</script>

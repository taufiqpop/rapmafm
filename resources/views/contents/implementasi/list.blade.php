@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

@section('contents')
    <style>
        .question-button {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            animation: blink 1s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                filter: brightness(100%);
            }

            50% {
                filter: brightness(200%);
            }
        }
    </style>

    {{-- Implementasi --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h3>{{ $title }}</h3>
                        </div>
                    </div>
                    {{-- Button Modal Information --}}
                    <div class="d-flex justify-content-end">
                        <div class="question-button" data-toggle="modal" data-target="#infoModal">
                            <i class="fas fa-question"></i>
                        </div>
                    </div>
                    {{-- Menu Tab --}}
                    <ul class="nav nav-tabs nav-pills nav-justified" id="soal-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="soal-tab" data-toggle="tab" href="#soal" role="tab"
                                aria-controls="soal" aria-selected="true">SOAL & KUNCI JAWABAN</a>
                        </li>
                        <li class="nav-item">
                            <a onclick="load_halaman('dokumentasi')" class="nav-link" id="dokumentasi-tab" data-toggle="tab"
                                href="#dokumentasi" role="tab" aria-controls="dokumentasi"
                                aria-selected="false">DOKUMENTASI PENILAIAN </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="load_halaman('penilaian')" class="nav-link" id="penilaian-tab" data-toggle="tab"
                                href="#penilaian" role="tab" aria-controls="penilaian" aria-selected="false">HASIL
                                PENILAIAN PESERTA DIDIK</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active mt-3" id="soal" role="tabpanel"
                            aria-labelledby="soal-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Soal & Kunci Jawaban</h3>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <table class="table table-bordered table-hover" id="dt-soal">
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
                        </div>

                        {{-- Dokumentasi Penilaian --}}
                        <div class="tab-pane fade mt-3" id="dokumentasi" role="tabpanel" aria-labelledby="dokumentasi-tab">
                        </div>

                        {{-- Hasil Penilaian Peserta Didik --}}
                        <div class="tab-pane fade mt-3" id="penilaian" role="tabpanel" aria-labelledby="penilaian-tab">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-soal-update" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-soal-updateLabel"
        aria-hidden="true">
        <form action="{{ route('implementasi.uploadSoal') }}" method="post" id="form-soal-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @csrf
            @method('PATCH')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-soal-updateLabel">Form Upload Soal & Kunci Jawaban</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" id="uploadFileSoal">
                            <label for="file_soal">Pilih File Soal & Kunci Jawaban</label>
                            <input type="file" class="form-control-file" id="file_soal" name="file_soal" required>
                            <small class="form-text text-muted">File harus berformat PDF || Max 2 MB</small>
                        </div>
                        <div id="soal-content" class="mt-4" style="display: none;">
                            <h5>Preview Soal</h5>
                            <div id="soal-table">
                                <!-- Embed PDF Preview -->
                                <embed id="pdf-preview" src="" type="application/pdf" width="100%"
                                    height="500px" />
                            </div>
                            <button type="button" id="delete-soal" class="btn btn-danger mt-2"><i
                                    class="bx bxs-trash"></i> Hapus File Soal</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Upload</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Modal Info --}}
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Penjelasan Implementasi Bentuk Penilaian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Sintaks ketiga dari AfEL, Guru diminta untuk ”mengimplementasikan teknik penilaian di
                        dalam kelas.” Sebagai bentuk terlaksananya sintaks ini, guru diminta untuk mengupload
                        dokumen berikut ini:
                    </p>
                    <ol>
                        <li>Dokumen soal dan kunci jawaban (Format pdf).</li>
                        <li>Dokumentasi penilaian (Format jpeg atau pdf).</li>
                        <li>Dokumentasi hasil penilaian peserta didik (Format excel yang sudah diisikan skor
                            peserta didik), sebagaimana file excel yang sudah disediakan AfEL pada sintaks kedua.</li>

                    </ol>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

        // Load Halaman
        function load_halaman(halaman, obj = {}) {
            if (obj?.sekolah_id) sessionStorage.setItem('sekolah_id', obj?.sekolah_id)

            $.ajax({
                type: "POST",
                url: "{{ route('implementasi.load_halaman') }}",
                data: {
                    halaman: halaman,
                    sekolah_id: sessionStorage.getItem('sekolah_id'),
                },
                dataType: "JSON",
                beforeSend: () => {
                    $(`#${halaman}`).html(
                        `<div class="d-flex align-items-center justify-content-center" style="min-height: 300px;"><img src="{{ asset('assets/images/loading.gif') }}" style="width: auto;"></div>`
                    );
                }
            }).then(res => {
                $(`#${halaman}`).html(res.html);
            })
        }

        // List
        function load_table() {
            table = $('#dt-soal').DataTable({
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
                        const button_upload_soal = $('<button>', {
                            class: `btn ${row.file_soal != null ? 'btn-success' : 'btn-dark'} btn-upload-soal`,
                            html: '<i class="bx bx-upload"></i> Upload Soal & Kunci Jawaban',
                            'data-id': data,
                            title: 'Upload Soal & Kunci Jawaban',
                            'data-placement': 'top',
                            'data-toggle': 'tooltip'
                        });

                        return $('<div>', {
                            class: 'btn-group',
                            html: () => {
                                let arr = [];
                                arr.push(button_upload_soal)
                                return arr;
                            }
                        }).prop('outerHTML');
                    }
                }, {
                    data: 'created_at'
                }]
            })
        }

        // Upload Soal & Kunci Jawaban
        $('#form-soal-update').on('submit', function(e) {
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
                    $('#modal-soal-update').find('.modal-dialog').LoadingOverlay('show');
                },
                success: (res) => {
                    $('#modal-soal-update').find('.modal-dialog').LoadingOverlay('hide', true);
                    $(this)[0].reset();
                    clearErrorMessage();
                    showSuccessToastr('Sukses', 'Berhasil Upload');
                    table.ajax.reload();
                    $('#modal-soal-update').modal('hide');
                },
                error: ({
                    status,
                    responseJSON
                }) => {
                    $('#modal-soal-update').find('.modal-dialog').LoadingOverlay('hide', true);

                    if (status == 422) {
                        generateErrorMessage(responseJSON);
                        return false;
                    }

                    showErrorToastr('Oops', responseJSON.msg)
                }
            });
        });

        $('#dt-soal').on('click', '.btn-upload-soal', function() {
            let tr = $(this).closest('tr');
            let data = table.row(tr).data();

            clearErrorMessage();
            $('#form-soal-update')[0].reset();

            $.each(data, (key, value) => {
                $('#update-' + key).val(value).trigger('change');
            });

            if (data.file_soal) {
                $('#soal-content').show();
                let fileUrl = `{{ asset('storage') }}/${data.file_soal}`;
                $('#pdf-preview').attr('src', fileUrl);
                $('#uploadFileSoal').hide();
            } else {
                $('#soal-content').hide();
                $('#uploadFileSoal').show();
            }

            $('#modal-soal-update').modal('show');
        });

        // Check File Max 2MB && .pdf
        $('#uploadFileSoal').on('change', function(event) {
            const fileInput = event.target;
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileType = file.type;
                const maxSize = 2 * 1024 * 1024;
                const validTypes = ['application/pdf'];

                if (!validTypes.includes(fileType)) {
                    Swal.fire({
                        title: "Format file salah",
                        text: "Hanya file PDF yang diperbolehkan",
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

        // Delete Soal
        $('#delete-soal').on('click', function() {
            Swal.fire({
                title: 'Anda Yakin?',
                text: "Anda akan menghapus file soal ini!",
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
                        url: BASE_URL + 'implementasi/deleteSoal/' + id,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === true) {
                                Swal.fire('Terhapus!', 'Berhasil Dihapus.', 'success');
                                $('#soal-content').hide();
                                $('#uploadFileSoal').show();
                                table.ajax.reload();
                            } else {
                                Swal.fire('Error!', response.msg, 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'Gagal Dihapus.', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endpush

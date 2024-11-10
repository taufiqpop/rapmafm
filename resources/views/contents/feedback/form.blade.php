@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

@section('contents')
    {{-- Feedback --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>
                                Form {{ $title }} - {{ $sekolah->nama }} ({{ $sekolah->kelas }}
                                {{ $sekolah->kode_kelas }})
                            </h3>
                            <hr>
                        </div>
                        <input type="hidden" name="sekolah_id" id="sekolah_id" value="{{ $sekolah->id }}">
                        <div class="col-md-12 mt-2">
                            <div class="mb-3">
                                <button class="btn btn-dark" onclick="history.back()"><i class="bx bx-arrow-back"></i>
                                    Kembali</button>
                            </div>
                            <table class="table table-bordered table-hover" id="dt-form">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center align-middle">No</th>
                                        <th scope="col" class="text-center align-middle">Nama</th>
                                        <th scope="col" class="text-center align-middle">Skor Kognitif</th>
                                        <th scope="col" class="text-center align-middle">Skor Afektif</th>
                                        <th scope="col" class="text-center align-middle">Skor Psikomotorik</th>
                                        <th scope="col" class="text-center align-middle">Skor Akhir</th>
                                        <th scope="col" class="text-center align-middle" style="width: 30%">
                                            Feedback
                                            <i class="fas fa-info-circle"
                                                title="Klik Untuk Melihat Contoh Penulisan Feedback" data-toggle="modal"
                                                data-target="#penulisan-feedback" style="cursor: pointer;"></i>
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

    {{-- Modal Contoh Penulisan Feedback --}}
    <div class="modal fade" id="penulisan-feedback" tabindex="-1" role="dialog" aria-labelledby="penulisan-feedbackLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penulisan-feedbackLabel">Contoh Penulisan Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="font-size: 0.9rem">
                        1. Siswa harus melatih kemampuan menganalisis komponen aktivitas operasional kas.<br>
                        2. Siswa harus melatih kemampuan menganalisis komponen aktivitas pendanaan kas.<br>
                        3. Siswa harus lebih aktif dalam diskusi dan mengerjakan tugas.<br>
                        4. Siswa harus melatih kepekaan rasa dalam kerjasama tim saat diskusi kelompok.<br>
                        5. Selamat, prestasi sudah baik, perlu dipertahankan.<br>
                    </p>
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

        // List
        function load_table() {
            table = $('#dt-form').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                language: dtLang,
                ajax: {
                    url: BASE_URL + 'feedback/form',
                    type: 'get',
                    dataType: 'json',
                    data: function(d) {
                        d.sekolah_id = $('#sekolah_id').val();
                    }
                },
                order: [
                    [8, 'desc']
                ],
                columnDefs: [{
                    targets: [0, -3],
                    searchable: false,
                    orderable: false,
                    className: 'text-center align-middle',
                }, {
                    targets: [1, 6],
                    className: 'text-left align-middle'
                }, {
                    targets: [2, 3, 4, 5],
                    className: 'text-center align-middle'
                }, {
                    targets: [-1, -2],
                    visible: false,
                }],
                columns: [{
                    data: 'DT_RowIndex'
                }, {
                    data: 'nama',
                }, {
                    data: 'skor_kognitif',
                }, {
                    data: 'skor_afektif',
                }, {
                    data: 'skor_psikomotorik',
                }, {
                    data: 'skor_akhir',
                }, {
                    data: 'feedback',
                    render: (data, type, row) => {
                        console.log(data);
                        let html =
                            `<center>
                                <div class="input-group">
                                    <textarea class="form-control" data-tabel="siswa" data-id="${row.id}" data-kolom="feedback" onchange="update_custom(this)">${data != null ? data : ''}</textarea>
                                </div>
                            </center>`
                        return html;
                    }
                }, {
                    data: 'id',
                }, {
                    data: 'created_at'
                }]
            })
        }

        function update_custom(ctx) {
            let id = $(ctx).data('id');
            let tabel = $(ctx).data('tabel');
            let kolom = $(ctx).data('kolom');
            let value = null;

            $.ajax({
                type: "POST",
                url: "{{ route('feedback.update_custom') }}",
                data: {
                    id: id ?? '{{ $sekolah->id }}',
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

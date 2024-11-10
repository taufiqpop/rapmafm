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
    {{-- Materi Rubrik (Kognitif) --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row pr-4">
                        <div class="col-md-12">
                            <h3>Data Rubrik - {{ $blueprint->ranah_penilaian }}</h3>
                            <button class="btn btn-dark mb-3" onclick="history.back()">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </button>
                            <h5>
                                - Guru diminta untuk mengisikan komposisi skor pada setiap level kognitif yang tersedia.<br>
                                - Guru diminta untuk menuliskan kriteria penilaian pada box yang tersedia.
                            </h5>
                        </div>
                        <div class="col-md-12 mt-2" id="kognitif">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dt-materi-rubrik">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center align-middle" style="width: 5%">No</th>
                                            <th scope="col" class="text-center align-middle" style="width: 400px">Materi
                                            </th>
                                            <th scope="col" class="text-center align-middle" style="width: 800px">
                                                Indikator
                                                Pembelajaran</th>
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
                            <hr>

                            {{-- Kriteria Penilaian --}}
                            <div class="col-md-12 mt-2">
                                <label for="kriteria_penilaian">
                                    <h4>KRITERIA PENILAIAN :</h4>
                                </label>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-info btn-kriteria" data-toggle="modal"
                                        data-target="#kriteriaModal"><i class="fas fa-info-circle"></i> Contoh</button>
                                </div>
                                <textarea class="form-control styled-textarea" name="kriteria_penilaian" id="kriteria_penilaian" cols="30"
                                    rows="10" placeholder="Masukkan Kriteria Penilaian.." data-id="{{ $blueprint->id }}" data-tabel="blueprint"
                                    data-kolom="kriteria_penilaian" onchange="update_custom(this)">{{ $blueprint->kriteria_penilaian }}</textarea>
                            </div>

                            {{-- Modal Kriteria --}}
                            <div class="modal fade" id="kriteriaModal" tabindex="-1" role="dialog"
                                aria-labelledby="kriteriaModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="kriteriaModalLabel">Contoh Kriteria Penilaian</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <h5>Contoh 1</h5>
                                                <p>
                                                    Instrumen tes dengan bentuk multiple choice untuk materi<br>
                                                    permintaan dan penawaran terdiri dari 40 soal.<br>
                                                    Setiap jawaban benar mendapatkan skor 2,5<br>
                                                    Setiap jawaban salah medapatkan skor 0<br>
                                                    Skor minimal siswa = 0<br>
                                                    Skor maksimal siswa = 100<br>
                                                </p>
                                            </div>
                                            <hr>
                                            <h5>Contoh 2</h5>
                                            <p>
                                                Instrumen tes dengan bentuk uraian untuk materi X terdiri dari x soal.<br>
                                                SOAL NOMOR 1<br>
                                                1. Siswa dapat menyebutkan 5 manfaat persamaan dasar akuntansi
                                                mendapat skor 10.<br>
                                                2. Siswa dapat menyebutkan 3 manfaat persamaan dasar akuntansi
                                                mendapat skor 5.<br>
                                                3. Siswa dapat menyebutkan 1 manfaat persamaan dasar akuntansi
                                                mendapat skor 3.<br>
                                                *Harus dapat menyebutkan manfaat utama dari persamaan dasar akuntansi =
                                                menghasilkan informasi keuangan.<br>
                                                Skor minimal siswa untuk soal nomor 1 = 0<br>
                                                Skor maksimal siswa untuk soal nomor 1 = 10<br>
                                                <br>
                                                SOAL NOMOR 2<br>
                                                1. Siswa dapat menguraikan jenis asset lancar mendapat skor 5.<br>
                                                2. Siswa dapat menguraikan jenis asset tetap mendapat skor 5.<br>
                                                3. Siswa dapat menguraikan jenis hutang lancar mendapat skor 3.<br>
                                                4. Siswa dapat menguraikan jenis hutang jangka panjang
                                                mendapat skor 3.<br>
                                                5. Siswa dapat menguraikan jenis ekuitas mendapat skor 4.<br>
                                                Skor minimal siswa untuk soal nomor 2 = 0<br>
                                                Skor maksimal siswa untuk soal nomor 2 = 20<br>
                                                <br>
                                                DAN SETERUSNYA.
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            load_table();

            $('#dt-materi-rubrik').on('input', '.custom-number-input', function() {
                if ($(this).val() > 100) {
                    $(this).val(100);
                }
            });
        });

        function load_table() {
            table = $('#dt-materi-rubrik').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                language: dtLang,
                ajax: {
                    url: BASE_URL + 'perumusan/rubrik/materi',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        blueprint_id: {{ $blueprint->id }},
                    }
                },
                order: [
                    [10, 'asc']
                ],
                columnDefs: [{
                    targets: [0, -2, 3, 4, 5, 6, 7, 8, 9],
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
                        let html =
                            `<textarea readonly class="form-control d-inline-block input-custom" value="${data}" data-tabel="materi_blueprint" data-id="${row.id}" data-kolom="materi" onchange="update_custom(this)">${data}</textarea>`;
                        return html;
                    }
                }, {
                    data: 'indikator',
                    render: (data, type, row) => {
                        let html = '<ul>';
                        data.forEach(value => {
                            html += `<li>
                            <textarea readonly class="form-control d-inline-block input-custom" value="${value.target_pengetahuan}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="target_pengetahuan" onchange="update_custom(this)">${value.target_pengetahuan}</textarea>
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
                                    <input ${value.rk_remember == 0 || value.rk_remember == null? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.rk_remember == 0 || value.rk_remember == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.rk_remember_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rk_remember_rubrik" id="rk_remember_rubrik" onchange="update_custom(this)" oninput="totalKognitifRubrik(this)">
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
                                    <input ${value.rk_understand == 0 || value.rk_understand == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.rk_understand == 0 || value.rk_understand == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.rk_understand_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rk_understand_rubrik" id="rk_understand_rubrik" onchange="update_custom(this)" oninput="totalKognitifRubrik(this)">
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
                                    <input ${value.rk_apply == 0 || value.rk_apply == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.rk_apply == 0 || value.rk_apply == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.rk_apply_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rk_apply_rubrik" id="rk_apply_rubrik" onchange="update_custom(this)" oninput="totalKognitifRubrik(this)">
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
                                    <input ${value.rk_analyze == 0 || value.rk_analyze == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.rk_analyze == 0 || value.rk_analyze == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.rk_analyze_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rk_analyze_rubrik" id="rk_analyze_rubrik" onchange="update_custom(this)" oninput="totalKognitifRubrik(this)">
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
                                    <input ${value.rk_evaluate == 0 || value.rk_evaluate == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.rk_evaluate == 0 || value.rk_evaluate == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.rk_evaluate_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rk_evaluate_rubrik" id="rk_evaluate_rubrik" onchange="update_custom(this)" oninput="totalKognitifRubrik(this)">
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
                                    <input ${value.rk_create == 0 | value.rk_create == null ? 'disabled' : '' } type="number" class="form-control custom-number-input ${value.rk_create == 0 | value.rk_create == null ? 'input-custom' : '' }" style="width: 50px; font-weight: bold;" value="${value.rk_create_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="rk_create_rubrik" id="rk_create_rubrik" onchange="update_custom(this)" oninput="totalKognitifRubrik(this)">
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
                                    <input readonly type="number" class="form-control custom-number-input input-custom" style="width: 50px; font-weight: bold;" value="${value.total_kognitif_rubrik}" data-tabel="indikator_blueprint" data-id="${value.id}" data-kolom="total_kognitif_rubrik" id="total_kognitif_rubrik" onchange="update_custom(this)">
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

        // Total Kognitif Rubrik
        function totalKognitifRubrik(element) {
            let rowId = $(element).data('id');

            let remember = parseFloat($(`input[data-id='${rowId}'][data-kolom='rk_remember_rubrik']`).val()) || 0;
            let understand = parseFloat($(`input[data-id='${rowId}'][data-kolom='rk_understand_rubrik']`).val()) || 0;
            let apply = parseFloat($(`input[data-id='${rowId}'][data-kolom='rk_apply_rubrik']`).val()) || 0;
            let analyze = parseFloat($(`input[data-id='${rowId}'][data-kolom='rk_analyze_rubrik']`).val()) || 0;
            let evaluate = parseFloat($(`input[data-id='${rowId}'][data-kolom='rk_evaluate_rubrik']`).val()) || 0;
            let create = parseFloat($(`input[data-id='${rowId}'][data-kolom='rk_create_rubrik']`).val()) || 0;

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

            $(`input[data-id='${rowId}'][data-kolom='total_kognitif_rubrik']`).val(total);

            update_custom($(`input[data-id='${rowId}'][data-kolom='total_kognitif_rubrik']`)[0], false);
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

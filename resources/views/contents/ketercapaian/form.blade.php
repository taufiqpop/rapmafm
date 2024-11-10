@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

@push('styles')
    <style>
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
    {{-- Ketercapaian --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="ml-2">
                        <h3>
                            Form Ketercapaian Tujuan - {{ $sekolah->nama }} ({{ $sekolah->kelas }}
                            {{ $sekolah->kode_kelas }})
                        </h3>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <div class="col-md-12 mt-2">
                                <label for="komentar_guru">
                                    <h4>KOMENTAR GURU ATAS KETERCAPAIAN PEMBELAJARAN :</h4>
                                </label>
                                <textarea class="form-control styled-textarea" name="komentar_guru" id="komentar_guru" cols="30" rows="10"
                                    placeholder="Masukkan Komentar.." data-tabel="sekolah" data-kolom="komentar_guru" onchange="update_custom(this)">{{ $sekolah->komentar_guru }}</textarea>
                                <div class="mt-3">
                                    <button class="btn btn-dark" onclick="history.back()"><i class="bx bx-arrow-back"></i>
                                        Kembali</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="col-md-12 mt-2">
                                <label for="strategi_pembelajaran">
                                    <h4>STRATEGI PEMBELAJARAN YANG AKAN DATANG :</h4>
                                </label>
                                <textarea class="form-control styled-textarea" name="strategi_pembelajaran" id="strategi_pembelajaran" cols="30"
                                    rows="10" placeholder="Masukkan Strategi Pembelajaran.." data-tabel="sekolah"
                                    data-kolom="strategi_pembelajaran" onchange="update_custom(this)">{{ $sekolah->strategi_pembelajaran }}</textarea>
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
        function update_custom(ctx) {
            let id = $(ctx).data('id');
            let tabel = $(ctx).data('tabel');
            let kolom = $(ctx).data('kolom');
            let value = null;

            $.ajax({
                type: "POST",
                url: "{{ route('ketercapaian.update_custom') }}",
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
                    table.ajax.reload();
                }
            })
        }
    </script>
@endpush

@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

@push('styles')
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
@endpush
@section('contents')
    {{-- Perumusan --}}
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
                    <ul class="nav nav-tabs nav-pills nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                aria-controls="home" aria-selected="true">TERMINOLOGI</a>
                        </li>
                        <li class="nav-item">
                            <a onclick="load_halaman('afel')" class="nav-link" id="afel-tab" data-toggle="tab"
                                href="#afel" role="tab" aria-controls="afel" aria-selected="false">AFEL </a>
                        </li>
                    </ul>

                    {{-- Terminologi --}}
                    <div class="tab-content">
                        <div class="tab-pane fade show active mt-3" id="home" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="row">
                                <div class="ml-3 mb-3">
                                    <h4>
                                        Guru diminta untuk membaca setiap teori asesmen pembelajaran, yang terdiri dari 5
                                        materi sebagaimana tersaji di bawah ini.
                                    </h4>
                                </div>
                                @foreach ($terminologi as $index => $item)
                                    <div class="col-12 mb-3">
                                        <div class="card d-flex flex-row">
                                            <img src="{{ asset('storage/' . $item->terminologi->logo) }}"
                                                class="card-img-left my-1" style="width: 250px; height: 200px">
                                            <div class="card-body">
                                                <h5 class="card-title" style="font-size: 1.3rem">{{ $index + 1 }}.
                                                    {{ $item->terminologi->nama }}
                                                </h5>
                                                <p class="card-text text-justify" style="font-size: 1.2rem">
                                                    {{ $item->terminologi->deskripsi }}</p>
                                                <div>
                                                    <button type="button" class="btn-lg btn-primary read-more-btn"
                                                        data-toggle="modal"
                                                        data-target="#modal-{{ $item->terminologi->id }}">
                                                        >> Klik Di Sini!
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Modal Detail Deskripsi --}}
                                    <div class="modal fade" id="modal-{{ $item->terminologi->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modal-{{ $item->terminologi->id }}-label"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modal-{{ $item->terminologi->id }}-label"
                                                        style="font-size: 1.3rem">
                                                        {{ $item->terminologi->nama }}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-justify" style="font-size: 1.1rem">
                                                        >> {{ $item->terminologi->deskripsi }}</p>
                                                </div>
                                                <div class="modal-body">
                                                    <embed src="{{ asset('storage/' . $item->terminologi->nama_pdf) }}"
                                                        type="application/pdf" width="100%" height="500px" />
                                                </div>
                                                <div class="modal-body"><input type="checkbox" class="checkbox-status"
                                                        data-id="{{ $item->id }}"
                                                        {{ $item->status == 1 ? 'checked' : '' }}> Saya
                                                    Sudah Paham</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- AFEL --}}
                        <div class="tab-pane fade mt-3" id="afel" role="tabpanel" aria-labelledby="afel-tab"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Info --}}
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Sintaks pertama dari AFEL "Perumusan Tujuan dan Kriteria
                        Sukses"</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Sebelum merumuskan tujuan dan kriteria sukses, Guru terlebih dahulu harus membaca 5 materi yang
                        terkait Teori Asesmen Pembelajaran.</p>
                    <p>Setelah itu Guru dapat mengakses menu AFEL, untuk melakukan aktivitas :</p>
                    <ol>
                        <li>Menginputkan identitas kelas</li>
                        <li>Merancang kisi-kisi</li>
                        <li>Merancang rubrik</li>
                    </ol>
                    <p>Seluruh menu tersebut, harus dikerjakan secara berurutan karena informasi antar menu saling terhubung
                        dan bersifat melengkapi.</p>
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
            checkTabStatus();
        });

        // Load Halaman
        function load_halaman(halaman) {

            $.ajax({
                type: "POST",
                url: "{{ route('perumusan.load_halaman') }}",
                data: {
                    halaman: halaman,
                },
                dataType: "JSON",
                beforeSend: () => {
                    if ($(`a[href="#${halaman}"]`).hasClass('disabled')) {
                        ($(`a[href="#${halaman}"]`).removeClass('disabled').trigger('click'))
                    } else {
                        ($(`a[href="#${halaman}"]`).closest('li.nav-item')).nextAll().find('a').addClass(
                            'disabled')
                    }
                    $(`#${halaman}`).html(
                        `<div class="d-flex align-items-center justify-content-center" style="min-height: 300px;"><img src="{{ asset('assets/images/loading.gif') }}" style="width: auto;"></div>`
                    );
                }
            }).then(res => {
                $(`#${halaman}`).html(res.html);
            })
        }

        // Check Status Terminologi
        function checkTabStatus() {
            let allChecked = true;
            $('.checkbox-status').each(function() {
                if (!this.checked) {
                    allChecked = false;
                    return false;
                }
            });

            $('#afel-tab').toggleClass('disabled', !allChecked);
        }

        $('.checkbox-status').on('change', function() {
            let id = $(this).data('id');
            let status = this.checked ? 1 : 0;

            $.ajax({
                url: "{{ route('perumusan.updateStatus') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                },
                success: function(response) {
                    showSuccessToastr('Sukses', 'Berhasil Mengubah Checklist');
                    checkTabStatus();
                },
                error: function(error) {
                    if (status == 422) {
                        generateErrorMessage(responseJSON);
                        return false;
                    }
                    showErrorToastr('oops', responseJSON.msg)
                }
            });
        });
    </script>
@endpush

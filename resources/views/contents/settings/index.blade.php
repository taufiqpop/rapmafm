@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal'];
@endphp

@section('contents')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-4">Information</h3>
                    <div class="row">
                        {{-- Owner --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="owner" class="form-label">Owner</label>
                                <input type="text" class="form-control" name="owner" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="owner" placeholder="Masukkan Owner"
                                    onchange="update_custom(this)" value="{{ $settings->owner }}">
                            </div>
                        </div>

                        {{-- Slogan --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="slogan" class="form-label">Slogan</label>
                                <input type="text" class="form-control" name="slogan" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="slogan" placeholder="Masukkan Slogan"
                                    onchange="update_custom(this)" value="{{ $settings->slogan }}">
                            </div>
                        </div>

                        {{-- Frekuensi --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="frekuensi" class="form-label">Frekuensi</label>
                                <input type="text" class="form-control" name="frekuensi" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="frekuensi" placeholder="Masukkan Frekuensi"
                                    onchange="update_custom(this)" value="{{ $settings->frekuensi }}">
                            </div>
                        </div>

                        {{-- Link Streaming --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="streaming" class="form-label">Link Streaming</label>
                                <input type="text" class="form-control" name="streaming" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="streaming"
                                    placeholder="Masukkan Link Streaming" onchange="update_custom(this)"
                                    value="{{ $settings->streaming }}">
                            </div>
                        </div>
                    </div>
                    <hr>

                    <h3 class="mb-4">Social Media</h3>
                    <div class="row">
                        {{-- Twitter --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="text" class="form-control" name="twitter" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="twitter" placeholder="Masukkan Twitter"
                                    onchange="update_custom(this)" value="{{ $settings->twitter }}">
                            </div>
                        </div>

                        {{-- Facebook --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="text" class="form-control" name="facebook" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="facebook" placeholder="Masukkan Facebook"
                                    onchange="update_custom(this)" value="{{ $settings->facebook }}">
                            </div>
                        </div>

                        {{-- Instagram --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="text" class="form-control" name="instagram" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="instagram" placeholder="Masukkan Instagram"
                                    onchange="update_custom(this)" value="{{ $settings->instagram }}">
                            </div>
                        </div>

                        {{-- YouTube --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="youtube" class="form-label">YouTube</label>
                                <input type="text" class="form-control" name="youtube" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="youtube" placeholder="Masukkan YouTube"
                                    onchange="update_custom(this)" value="{{ $settings->youtube }}">
                            </div>
                        </div>

                        {{-- Spotify --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="spotify" class="form-label">Spotify</label>
                                <input type="text" class="form-control" name="spotify" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="spotify" placeholder="Masukkan Spotify"
                                    onchange="update_custom(this)" value="{{ $settings->spotify }}">
                            </div>
                        </div>

                        {{-- Whatsapp --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="whatsapp" class="form-label">Whatsapp</label>
                                <input type="text" class="form-control" name="whatsapp" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="whatsapp" placeholder="Masukkan Whatsapp"
                                    onchange="update_custom(this)" value="{{ $settings->whatsapp }}">
                            </div>
                        </div>

                        {{-- Blogger --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="blogger" class="form-label">Blogger</label>
                                <input type="text" class="form-control" name="blogger" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="blogger" placeholder="Masukkan Blogger"
                                    onchange="update_custom(this)" value="{{ $settings->blogger }}">
                            </div>
                        </div>

                        {{-- TikTok --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="tiktok" class="form-label">TikTok</label>
                                <input type="text" class="form-control" name="tiktok" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="tiktok" placeholder="Masukkan TikTok"
                                    onchange="update_custom(this)" value="{{ $settings->tiktok }}">
                            </div>
                        </div>

                    </div>
                    <hr>

                    <h3 class="mb-4">Contact Person</h3>
                    <div class="row">
                        {{-- Nama Media Partner --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="nama_medpart" class="form-label">Nama Media Partner</label>
                                <input type="text" class="form-control" name="nama_medpart" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="nama_medpart"
                                    placeholder="Masukkan Nama Media Partner" onchange="update_custom(this)"
                                    value="{{ $settings->nama_medpart }}">
                            </div>
                        </div>

                        {{-- No HP Media Partner --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="no_medpart" class="form-label">No HP Media Partner</label>
                                <input type="text" class="form-control" name="no_medpart" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="no_medpart"
                                    placeholder="Masukkan No HP Media Partner" onchange="update_custom(this)"
                                    value="{{ $settings->no_medpart }}">
                            </div>
                        </div>

                        {{-- Nama M-Talent --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="nama_mtalent" class="form-label">Nama M-Talent</label>
                                <input type="text" class="form-control" name="nama_mtalent" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="nama_mtalent"
                                    placeholder="Masukkan Nama M-Talent" onchange="update_custom(this)"
                                    value="{{ $settings->nama_mtalent }}">
                            </div>
                        </div>

                        {{-- No HP M-Talent --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="no_mtalent" class="form-label">No HP M-Talent</label>
                                <input type="text" class="form-control" name="no_mtalent" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="no_mtalent"
                                    placeholder="Masukkan No HP M-Talent" onchange="update_custom(this)"
                                    value="{{ $settings->no_mtalent }}">
                            </div>
                        </div>

                        {{-- Gmail --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="gmail   " class="form-label">Gmail</label>
                                <input type="text" class="form-control" name="gmail " data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="gmail " placeholder="Masukkan Gmail"
                                    onchange="update_custom(this)" value="{{ $settings->gmail }}">
                            </div>
                        </div>

                        {{-- Yahoo Mail --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="ymail" class="form-label">Yahoo Mail</label>
                                <input type="text" class="form-control" name="ymail" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="ymail" placeholder="Masukkan Yahoo Mail"
                                    onchange="update_custom(this)" value="{{ $settings->ymail }}">
                            </div>
                        </div>

                    </div>
                    <hr>

                    <h3 class="mb-4">About</h3>
                    <div class="row">
                        {{-- Deskripsi --}}
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="about" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="about" cols="30" rows="10" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="about" placeholder="Masukkan Deskripsi"
                                    onchange="update_custom(this)">{{ $settings->about }}</textarea>
                            </div>
                        </div>

                        {{-- Link --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="link_about" class="form-label">Link</label>
                                <input type="text" class="form-control" name="link_about" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="link_about" placeholder="Masukkan Link"
                                    onchange="update_custom(this)" value="{{ $settings->link_about }}">
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" cols="30" rows="3" data-tabel="settings"
                                    data-id="{{ $settings->id }}" data-kolom="alamat" placeholder="Masukkan Alamat" onchange="update_custom(this)">{{ $settings->alamat }}</textarea>
                            </div>
                        </div>
                    </div>
                    <hr>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Update Custom (Autosave)
        function update_custom(ctx) {
            let id = $(ctx).data('id');
            let tabel = $(ctx).data('tabel');
            let kolom = $(ctx).data('kolom');
            let value = null;

            $.ajax({
                type: "POST",
                url: "{{ route('settings.update_custom') }}",
                data: {
                    id: id ?? '{{ $settings->id }}',
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

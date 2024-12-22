@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal'];
@endphp

@section('contents')
    {{-- List --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-success waves-effect waves-light btn-export">
                                    <i class="bx bx-file"></i> Export Excel
                                </button>
                                @if (rbacCheck('alumni', 2))
                                    <button type="button"
                                        class="btn btn-success btn-rounded waves-effect waves-light btn-tambah">
                                        <i class="bx bx-plus-circle mr-1"></i> Tambah
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table class="table table-striped" id="table-data" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nama Panggilan</th>
                                    <th>Divisi</th>
                                    <th>Tahun Kepengurusan</th>
                                    <th>Jenis Kelamin</th>
                                    <th>No HP</th>
                                    <th>Program Studi</th>
                                    <th>Action</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create --}}
    <div id="modal-alumni" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-alumniLabel"
        aria-hidden="true">
        <form action="{{ route('alumni.store') }}" method="post" id="form-alumni" autocomplete="off">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-alumniLabel">Form Alumni</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Nama Lengkap --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="fullname">Nama Lengkap</label>
                                    <input type="text" name="fullname" id="fullname" class="form-control"
                                        placeholder="Masukkan Nama Lengkap" required>
                                    <div id="error-fullname"></div>
                                </div>
                            </div>

                            {{-- Nama Panggilan --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="nickname">Nama Panggilan</label>
                                    <input type="text" name="nickname" id="nickname" class="form-control"
                                        placeholder="Masukkan Nama Panggilan" required>
                                    <div id="error-nickname"></div>
                                </div>
                            </div>

                            {{-- Divisi --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="divisi">Divisi</label>
                                    <select name="divisi" id="divisi" class="form-control" required>
                                        <option value="" selected disabled>Pilih Divisi</option>
                                        @foreach ($ref_divisi as $divisi)
                                            <option value="{{ $divisi->nama }}">{{ $divisi->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div id="error-divisi"></div>
                                </div>
                            </div>

                            {{-- Sub Divisi --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="sub_divisi">Sub Divisi</label>
                                    <select name="sub_divisi" id="sub_divisi" class="form-control" required>
                                        <option value="" selected disabled>Pilih Sub Divisi</option>
                                    </select>
                                    <div id="error-sub_divisi"></div>
                                </div>
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="gender">Jenis Kelamin</label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    <div id="error-gender"></div>
                                </div>
                            </div>

                            {{-- No HP --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="no_hp">No HP</label>
                                    <input type="number" name="no_hp" id="no_hp" class="form-control"
                                        placeholder="Masukkan No HP">
                                    <small style="color: red">*Optional</small>
                                    <div id="error-no_hp"></div>
                                </div>
                            </div>

                            {{-- Fakultas --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="fakultas">Fakultas</label>
                                    <input type="text" name="fakultas" id="fakultas" class="form-control"
                                        placeholder="Masukkan Fakultas" required>
                                    <div id="error-fakultas"></div>
                                </div>
                            </div>

                            {{-- Program Studi --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="prodi">Program Studi</label>
                                    <input type="text" name="prodi" id="prodi" class="form-control"
                                        placeholder="Masukkan Program Studi" required>
                                    <div id="error-prodi"></div>
                                </div>
                            </div>

                            {{-- Tahun Kepengurusan --}}
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="tahun_kepengurusan">Tahun Kepengurusan</label>
                                    <input type="number" name="tahun_kepengurusan" id="tahun_kepengurusan"
                                        class="form-control" placeholder="Tahun Kepengurusan" required>
                                    <div id="error-tahun_kepengurusan"></div>
                                </div>
                            </div>

                            {{-- Instagram --}}
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" name="instagram" id="instagram" class="form-control"
                                        placeholder="Masukkan Instagram (Tanpa @)" required>
                                    <div id="error-instagram"></div>
                                </div>
                            </div>

                            {{-- Twitter --}}
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="twitter">Twitter</label>
                                    <input type="text" name="twitter" id="twitter" class="form-control"
                                        placeholder="Masukkan Twitter (Tanpa @)" required>
                                    <div id="error-twitter"></div>
                                    <small style="color: red">*Optional</small>
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

    {{-- Update --}}
    <div id="modal-alumni-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-alumni-updateLabel" aria-hidden="true">
        <form action="{{ route('alumni.update') }}" method="post" id="form-alumni-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-alumni-updateLabel">Form Alumni</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Nama Lengkap --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-fullname">Nama Lengkap</label>
                                    <input type="text" name="fullname" id="update-fullname" class="form-control"
                                        placeholder="Masukkan Nama Lengkap" required>
                                    <div id="error-update-fullname"></div>
                                </div>
                            </div>

                            {{-- Nama Panggilan --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-nickname">Nama Panggilan</label>
                                    <input type="text" name="nickname" id="update-nickname" class="form-control"
                                        placeholder="Masukkan Nama Panggilan" required>
                                    <div id="error-update-nickname"></div>
                                </div>
                            </div>

                            {{-- Divisi --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-divisi">Divisi</label>
                                    <select name="divisi" id="update-divisi" class="form-control" required>
                                        <option value="" selected disabled>Pilih Divisi</option>
                                        @foreach ($ref_divisi as $divisi)
                                            <option value="{{ $divisi->nama }}">{{ $divisi->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div id="error-update-divisi"></div>
                                </div>
                            </div>

                            {{-- Sub Divisi --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-sub_divisi">Sub Divisi</label>
                                    <select name="sub_divisi" id="update-sub_divisi" class="form-control" required>
                                        <option value="" selected disabled>Pilih Sub Divisi</option>
                                    </select>
                                    <div id="error-update-sub_divisi"></div>
                                </div>
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-gender">Jenis Kelamin</label>
                                    <select name="gender" id="update-gender" class="form-control" required>
                                        <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    <div id="error-update-gender"></div>
                                </div>
                            </div>

                            {{-- No HP --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-no_hp">No HP</label>
                                    <input type="number" name="no_hp" id="update-no_hp" class="form-control"
                                        placeholder="Masukkan No HP">
                                    <div id="error-update-no_hp"></div>
                                </div>
                            </div>

                            {{-- Fakultas --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-fakultas">Fakultas</label>
                                    <input type="text" name="fakultas" id="update-fakultas" class="form-control"
                                        placeholder="Masukkan Fakultas" required>
                                    <div id="error-update-fakultas"></div>
                                </div>
                            </div>

                            {{-- Program Studi --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-prodi">Program Studi</label>
                                    <input type="text" name="prodi" id="update-prodi" class="form-control"
                                        placeholder="Masukkan Program Studi" required>
                                    <div id="error-update-prodi"></div>
                                </div>
                            </div>

                            {{-- Tahun Kepengurusan --}}
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="update-tahun_kepengurusan">Tahun Kepengurusan</label>
                                    <input type="number" name="tahun_kepengurusan" id="update-tahun_kepengurusan"
                                        class="form-control" placeholder="Tahun Kepengurusan" required>
                                    <div id="error-update-tahun_kepengurusan"></div>
                                </div>
                            </div>

                            {{-- Instagram --}}
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="update-instagram">Instagram</label>
                                    <input type="text" name="instagram" id="update-instagram" class="form-control"
                                        placeholder="Masukkan Instagram (Tanpa @)" required>
                                    <div id="error-update-instagram"></div>
                                </div>
                            </div>

                            {{-- Twitter --}}
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="update-twitter">Twitter</label>
                                    <input type="text" name="twitter" id="update-twitter" class="form-control"
                                        placeholder="Masukkan Twitter (Tanpa @)" required>
                                    <div id="error-update-twitter"></div>
                                    <small style="color: red">*Optional</small>
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

    {{-- Change Rank --}}
    <div id="modal-alumni-rank" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-alumni-rankLabel" aria-hidden="true">
        <form action="{{ route('alumni.changeRank') }}" method="post" id="form-alumni-rank" autocomplete="off">
            <input type="hidden" name="id" id="rank-id">
            @method('PATCH')
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-alumni-rankLabel">Form Ganti Pangkat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Ganti Rank --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="rank-rank">Ganti Pengkat</label>
                                    <select name="rank" id="rank-rank" class="form-control" required>
                                        <option value="" selected disabled>Pilih Pangkat</option>
                                        <option value="Crew">Crew</option>
                                        <option value="Pengurus">Pengurus</option>
                                        <option value="Alumni">Alumni</option>
                                    </select>
                                    <div id="error-rank-rank"></div>
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
@endsection

@push('scripts')
    <script src="{{ asset('js/page/personalia/members/alumni/list.js?q=' . Str::random(5)) }}"></script>
@endpush

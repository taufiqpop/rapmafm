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
                    @if (rbacCheck('kerja_bakti', 2))
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <div class="text-sm-right">
                                    <button type="button"
                                        class="btn btn-success btn-rounded waves-effect waves-light btn-tambah"><i
                                            class="bx bx-plus-circle mr-1"></i> Tambah</button>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- Table --}}
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table class="table table-striped" id="table-data" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>Tujuan</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Anggota</th>
                                    <th>Kendala</th>
                                    <th>Status</th>
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
    <div id="modal-kerja-bakti" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-kerja-baktiLabel"
        aria-hidden="true">
        <form action="{{ route('kerja-bakti.store') }}" method="post" id="form-kerja-bakti" autocomplete="off">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-kerja-baktiLabel">Form Kerja Bakti</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Tujuan --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tujuan">Tujuan</label>
                                    <input type="text" name="tujuan" id="tujuan" class="form-control"
                                        placeholder="Masukkan Tujuan" required>
                                    <div id="error-tujuan"></div>
                                </div>
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="datetime-local" name="tanggal" id="tanggal" class="form-control"
                                        placeholder="Masukkan Tanggal" required>
                                    <div id="error-tanggal"></div>
                                </div>
                            </div>

                            {{-- Jumlah Pengurus --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="jumlah_pengurus">Jumlah Pengurus</label>
                                    <input type="number" name="jumlah_pengurus" id="jumlah_pengurus" class="form-control"
                                        placeholder="Masukkan Jumlah Pengurus">
                                    <div id="error-jumlah_pengurus"></div>
                                </div>
                            </div>

                            {{-- Jumlah Crew --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="jumlah_crew">Jumlah Crew</label>
                                    <input type="number" name="jumlah_crew" id="jumlah_crew" class="form-control"
                                        placeholder="Masukkan Jumlah Crew">
                                    <div id="error-jumlah_crew"></div>
                                </div>
                            </div>

                            {{-- Kendala --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="kendala">Kendala</label>
                                    <input type="text" name="kendala" id="kendala" class="form-control"
                                        placeholder="Masukkan Kendala">
                                    <div id="error-kendala"></div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="Status">Status</label>
                                    <select name="status" id="Status" class="form-control" required>
                                        <option value="" selected disabled>Pilih Status</option>
                                        <option value="Belum Terlaksana">Belum Terlaksana</option>
                                        <option value="Sudah Terlaksana">Sudah Terlaksana</option>
                                        <option value="Tidak Terlaksana">Tidak Terlaksana</option>
                                    </select>
                                    <div id="error-status"></div>
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
    <div id="modal-kerja-bakti-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-kerja-bakti-updateLabel" aria-hidden="true">
        <form action="{{ route('kerja-bakti.update') }}" method="post" id="form-kerja-bakti-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-kerja-bakti-updateLabel">Form Kerja Bakti</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Tujuan --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-tujuan">Tujuan</label>
                                    <input type="text" name="tujuan" id="update-tujuan" class="form-control"
                                        placeholder="Masukkan Tujuan" required>
                                    <div id="error-update-tujuan"></div>
                                </div>
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-tanggal">Tanggal</label>
                                    <input type="datetime-local" name="tanggal" id="update-tanggal" class="form-control"
                                        placeholder="Masukkan Tanggal" required>
                                    <div id="error-update-tanggal"></div>
                                </div>
                            </div>

                            {{-- Jumlah Pengurus --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-jumlah_pengurus">Jumlah Pengurus</label>
                                    <input type="number" name="jumlah_pengurus" id="update-jumlah_pengurus"
                                        class="form-control" placeholder="Masukkan Jumlah Pengurus">
                                    <div id="error-update-jumlah_pengurus"></div>
                                </div>
                            </div>

                            {{-- Jumlah Crew --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-jumlah_crew">Jumlah Crew</label>
                                    <input type="number" name="jumlah_crew" id="update-jumlah_crew"
                                        class="form-control" placeholder="Masukkan Jumlah Crew">
                                    <div id="error-update-jumlah_crew"></div>
                                </div>
                            </div>

                            {{-- Kendala --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-kendala">Kendala</label>
                                    <input type="text" name="kendala" id="update-kendala" class="form-control"
                                        placeholder="Masukkan Kendala">
                                    <div id="error-update-kendala"></div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-status">Status</label>
                                    <select name="status" id="update-status" class="form-control" required>
                                        <option value="" selected disabled>Pilih Status</option>
                                        <option value="Belum Terlaksana">Belum Terlaksana</option>
                                        <option value="Sudah Terlaksana">Sudah Terlaksana</option>
                                        <option value="Tidak Terlaksana">Tidak Terlaksana</option>
                                    </select>
                                    <div id="error-update-status"></div>
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
    <script src="{{ asset('js/page/kerja-bakti/list.js?q=' . Str::random(5)) }}"></script>
@endpush

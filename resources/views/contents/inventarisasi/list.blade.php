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
                    @if (rbacCheck('inventarisasi', 2))
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
                                    <th>Nama Barang</th>
                                    <th>Kode</th>
                                    <th>Kondisi</th>
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
    <div id="modal-inventarisasi" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-inventarisasiLabel" aria-hidden="true">
        <form action="{{ route('inventarisasi.store') }}" method="post" id="form-inventarisasi" autocomplete="off">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-inventarisasiLabel">Form Inventarisasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Nama Barang --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="barang">Nama Barang</label>
                                    <input type="text" name="barang" id="barang" class="form-control"
                                        placeholder="Masukkan Nama Barang" required>
                                    <div id="error-barang"></div>
                                </div>
                            </div>

                            {{-- Kondisi --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="kondisi">Kondisi</label>
                                    <input type="text" name="kondisi" id="kondisi" class="form-control"
                                        placeholder="Masukkan Kondisi" required>
                                    <div id="error-kondisi"></div>
                                </div>
                            </div>

                            {{-- Kode --}}
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="kode">Kode</label>
                                    <input type="text" name="kode" id="kode" class="form-control"
                                        placeholder="Masukkan Kode" required>
                                    <div id="error-kode"></div>
                                </div>
                            </div>

                            {{-- Nomor --}}
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="nomor">Nomor</label>
                                    <input type="number" name="nomor" id="nomor" class="form-control"
                                        placeholder="Masukkan Nomor" required>
                                    <div id="error-nomor"></div>
                                </div>
                            </div>

                            {{-- Tahun --}}
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <input type="number" name="tahun" id="tahun" class="form-control"
                                        placeholder="Masukkan Tahun" required>
                                    <div id="error-tahun"></div>
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
    <div id="modal-inventarisasi-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-inventarisasi-updateLabel" aria-hidden="true">
        <form action="{{ route('inventarisasi.update') }}" method="post" id="form-inventarisasi-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-inventarisasi-updateLabel">Form Inventarisasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Nama Barang --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-barang">Nama Barang</label>
                                    <input type="text" name="barang" id="update-barang" class="form-control"
                                        placeholder="Masukkan Nama Barang" required>
                                    <div id="error-update-barang"></div>
                                </div>
                            </div>

                            {{-- Kondisi --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-kondisi">Kondisi</label>
                                    <input type="text" name="kondisi" id="update-kondisi" class="form-control"
                                        placeholder="Masukkan Kondisi" required>
                                    <div id="error-update-kondisi"></div>
                                </div>
                            </div>

                            {{-- Kode --}}
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="update-kode">Kode</label>
                                    <input type="text" name="kode" id="update-kode" class="form-control"
                                        placeholder="Masukkan Kode" required>
                                    <div id="error-update-kode"></div>
                                </div>
                            </div>

                            {{-- Nomor --}}
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="update-nomor">Nomor</label>
                                    <input type="number" name="nomor" id="update-nomor" class="form-control"
                                        placeholder="Masukkan Nomor" required>
                                    <div id="error-update-nomor"></div>
                                </div>
                            </div>

                            {{-- Tahun --}}
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="update-tahun">Tahun</label>
                                    <input type="number" name="tahun" id="update-tahun" class="form-control"
                                        placeholder="Masukkan Tahun" required>
                                    <div id="error-update-tahun"></div>
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
    <script src="{{ asset('js/page/inventarisasi/list.js?q=' . Str::random(5)) }}"></script>
@endpush

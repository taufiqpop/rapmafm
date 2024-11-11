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
                    @if (rbacCheck('struktur_organisasi', 2))
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
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table class="table table-striped" id="table-data" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th>Divisi</th>
                                    <th>Status</th>
                                    <th>Tahun</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
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
    <div id="modal-struktur-organisasi" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-struktur-organisasiLabel" aria-hidden="true">
        <form action="{{ route('struktur-organisasi.store') }}" method="post" id="form-struktur-organisasi"
            autocomplete="off">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-struktur-organisasiLabel">Form Struktur Organisasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="divisi">Divisi</label>
                                    <input type="text" name="divisi" id="divisi" class="form-control"
                                        placeholder="Masukkan Divisi" required>
                                    <div id="error-divisi"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="pangkat">Status</label>
                                    <select name="pangkat" id="pangkat" class="form-control" required>
                                        <option value="" selected disabled>Pilih Status Kepengurusan</option>
                                        <option value="Pengurus">Pengurus</option>
                                        <option value="Crew">Crew</option>
                                    </select>
                                    <div id="error-pangkat"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <input type="number" name="tahun" id="tahun" class="form-control"
                                        placeholder="Masukkan Tahun" required>
                                    <div id="error-tahun"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="order">Order</label>
                                    <input type="number" name="order" id="order" class="form-control"
                                        placeholder="Masukkan Order" required>
                                    <div id="error-order"></div>
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
    <div id="modal-struktur-organisasi-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-struktur-organisasi-updateLabel" aria-hidden="true">
        <form action="{{ route('struktur-organisasi.update') }}" method="post" id="form-struktur-organisasi-update"
            autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-struktur-organisasi-updateLabel">Form Struktur Organisasi
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-divisi">Divisi</label>
                                    <input type="text" name="divisi" id="update-divisi" class="form-control"
                                        placeholder="Masukkan Divisi" required>
                                    <div id="error-update-divisi"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-pangkat">Pangkat</label>
                                    <select name="pangkat" id="update-pangkat" class="form-control" required>
                                        <option value="" selected disabled>Pilih Status Kepengurusan</option>
                                        <option value="Pengurus">Pengurus</option>
                                        <option value="Crew">Crew</option>
                                    </select>
                                    <div id="error-update-pangkat"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-tahun">Tahun</label>
                                    <input type="number" name="tahun" id="update-tahun" class="form-control"
                                        placeholder="Masukkan Tahun" required>
                                    <div id="error-update-tahun"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-order">Order</label>
                                    <input type="number" name="order" id="update-order" class="form-control"
                                        placeholder="Masukkan Order" required>
                                    <div id="error-update-order"></div>
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
    <script src="{{ asset('js/page/struktur-organisasi/list.js?q=' . Str::random(5)) }}"></script>
@endpush

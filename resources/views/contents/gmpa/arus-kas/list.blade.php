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
                    @if (rbacCheck('arus_kas', 2))
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
                                    <th>Bulan</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Pemasukan</th>
                                    <th>Pengeluaran</th>
                                    <th>Jumlah</th>
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
    <div id="modal-arus-kas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-arus-kasLabel"
        aria-hidden="true">
        <form action="{{ route('arus-kas.store') }}" method="post" id="form-arus-kas" autocomplete="off">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-arus-kasLabel">Form Arus Kas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                                    <div id="error-tanggal"></div>
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" name="keterangan" id="keterangan" class="form-control"
                                        placeholder="Masukkan Keterangan" required>
                                    <div id="error-keterangan"></div>
                                </div>
                            </div>

                            {{-- Pemasukan --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="pemasukan">Pemasukan</label>
                                    <input type="number" name="pemasukan" id="pemasukan" class="form-control"
                                        placeholder="Masukkan Pemasukan">
                                    <div id="error-pemasukan"></div>
                                    <small style="color: red">*Kosongkan Jika Tidak Ada Pemasukan</small>
                                </div>
                            </div>

                            {{-- Pengeluaran --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="pengeluaran">Pengeluaran</label>
                                    <input type="number" name="pengeluaran" id="pengeluaran" class="form-control"
                                        placeholder="Masukkan Pengeluaran">
                                    <div id="error-pengeluaran"></div>
                                    <small style="color: red">*Kosongkan Jika Tidak Ada Pengeluaran</small>
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
    <div id="modal-arus-kas-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-arus-kas-updateLabel" aria-hidden="true">
        <form action="{{ route('arus-kas.update') }}" method="post" id="form-arus-kas-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-arus-kas-updateLabel">Form Arus Kas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="update-tanggal" class="form-control"
                                        required>
                                    <div id="update-error-tanggal"></div>
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-keterangan">Keterangan</label>
                                    <input type="text" name="keterangan" id="update-keterangan" class="form-control"
                                        placeholder="Masukkan Keterangan" required>
                                    <div id="error-update-keterangan"></div>
                                </div>
                            </div>

                            {{-- Pemasukan --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-pemasukan">Pemasukan</label>
                                    <input type="number" name="pemasukan" id="update-pemasukan" class="form-control"
                                        placeholder="Masukkan Pemasukan">
                                    <div id="error-update-pemasukan"></div>
                                    <small style="color: red">*Kosongkan Jika Tidak Ada Pemasukan</small>
                                </div>
                            </div>

                            {{-- Pengeluaran --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-pengeluaran">Pengeluaran</label>
                                    <input type="number" name="pengeluaran" id="update-pengeluaran"
                                        class="form-control" placeholder="Masukkan Pengeluaran">
                                    <div id="error-update-pengeluaran"></div>
                                    <small style="color: red">*Kosongkan Jika Tidak Ada Pengeluaran</small>
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
    <script src="{{ asset('js/page/gmpa/arus-kas/list.js?q=' . Str::random(5)) }}"></script>
@endpush

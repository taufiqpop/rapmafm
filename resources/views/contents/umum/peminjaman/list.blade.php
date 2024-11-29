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
                    @if (rbacCheck('peminjaman', 2))
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
                                    <th>Barang</th>
                                    <th>Peminjam</th>
                                    <th>Tanggal</th>
                                    <th>Fee</th>
                                    <th>Keterangan</th>
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
    <div id="modal-peminjaman" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-peminjamanLabel"
        aria-hidden="true">
        <form action="{{ route('peminjaman.store') }}" method="post" id="form-peminjaman" autocomplete="off">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-peminjamanLabel">Form Peminjaman</h5>
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

                            {{-- Jumlah Barang --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="jumlah">Jumlah Barang</label>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control"
                                        placeholder="Masukkan Jumlah Barang" required>
                                    <div id="error-jumlah"></div>
                                </div>
                            </div>

                            {{-- Nama Peminjam --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="nama_peminjam">Nama Peminjam</label>
                                    <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control"
                                        placeholder="Masukkan Nama Peminjam" required>
                                    <div id="error-nama_peminjam"></div>
                                </div>
                            </div>

                            {{-- Asal Peminjam --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="asal_peminjam">Asal Peminjam</label>
                                    <input type="text" name="asal_peminjam" id="asal_peminjam" class="form-control"
                                        placeholder="Masukkan Asal Peminjam" required>
                                    <div id="error-asal_peminjam"></div>
                                </div>
                            </div>

                            {{-- Tanggal Pinjam --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tgl_pinjam">Tanggal Pinjam</label>
                                    <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control"
                                        placeholder="Masukkan Tanggal Pinjam" required>
                                    <div id="error-tgl_pinjam"></div>
                                </div>
                            </div>

                            {{-- Tanggal Kembali --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tgl_kembali">Tanggal Kembali</label>
                                    <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control"
                                        placeholder="Masukkan Tanggal Kembali">
                                    <div id="error-tgl_kembali"></div>
                                </div>
                            </div>

                            {{-- Fee --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="fee">Fee</label>
                                    <input type="text" name="formatted_fee" id="fee" class="form-control"
                                        placeholder="Masukkan Fee">
                                    <input type="hidden" name="fee" id="fee-hidden">
                                    <div id="error-fee"></div>
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" name="keterangan" id="keterangan" class="form-control"
                                        placeholder="Masukkan Keterangan">
                                    <div id="error-keterangan"></div>
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
    <div id="modal-peminjaman-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-peminjaman-updateLabel" aria-hidden="true">
        <form action="{{ route('peminjaman.update') }}" method="post" id="form-peminjaman-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-peminjaman-updateLabel">Form Peminjaman</h5>
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

                            {{-- Jumlah Barang --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-jumlah">Jumlah Barang</label>
                                    <input type="number" name="jumlah" id="update-jumlah" class="form-control"
                                        placeholder="Masukkan Jumlah Barang" required>
                                    <div id="error-update-jumlah"></div>
                                </div>
                            </div>

                            {{-- Nama Peminjam --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-nama_peminjam">Nama Peminjam</label>
                                    <input type="text" name="nama_peminjam" id="update-nama_peminjam"
                                        class="form-control" placeholder="Masukkan Nama Peminjam" required>
                                    <div id="error-nama_peminjam"></div>
                                </div>
                            </div>

                            {{-- Asal Peminjam --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-asal_peminjam">Asal Peminjam</label>
                                    <input type="text" name="asal_peminjam" id="update-asal_peminjam"
                                        class="form-control" placeholder="Masukkan Asal Peminjam" required>
                                    <div id="error-asal_peminjam"></div>
                                </div>
                            </div>

                            {{-- Tanggal Pinjam --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-tgl_pinjam">Tanggal Pinjam</label>
                                    <input type="date" name="tgl_pinjam" id="update-tgl_pinjam" class="form-control"
                                        placeholder="Masukkan Tanggal Pinjam" required>
                                    <div id="error-update-tgl_pinjam"></div>
                                </div>
                            </div>

                            {{-- Tanggal Kembali --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-tgl_kembali">Tanggal Kembali</label>
                                    <input type="date" name="tgl_kembali" id="update-tgl_kembali"
                                        class="form-control" placeholder="Masukkan Tanggal Kembali">
                                    <div id="error-update-tgl_kembali"></div>
                                </div>
                            </div>

                            {{-- Fee --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-fee">Fee</label>
                                    <input type="text" name="formatted_fee" id="update-fee" class="form-control"
                                        placeholder="Masukkan Fee">
                                    <input type="hidden" name="fee" id="update-fee-hidden">
                                    <div id="error-update-fee"></div>
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-keterangan">Keterangan</label>
                                    <input type="text" name="keterangan" id="update-keterangan" class="form-control"
                                        placeholder="Masukkan Keterangan">
                                    <div id="error-update-keterangan"></div>
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
    <script src="{{ asset('js/page/umum/peminjaman/list.js?q=' . Str::random(5)) }}"></script>
@endpush

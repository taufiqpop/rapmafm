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
                    @if (rbacCheck('surat', 2))
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
                                    <th>Perihal</th>
                                    <th>Tanggal</th>
                                    <th>Asal Surat</th>
                                    <th>Nomor Surat</th>
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
    <div id="modal-surat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-suratLabel"
        aria-hidden="true">
        <form action="{{ route('surat.store') }}" method="post" id="form-surat" autocomplete="off">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-suratLabel">Form Surat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Perihal --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="perihal">Perihal</label>
                                        <select name="perihal" id="perihal" class="form-control" required>
                                            <option value="" selected disabled>Pilih Perihal</option>
                                            <option value="Surat Masuk">Surat Masuk</option>
                                            <option value="Surat Keluar">Surat Keluar</option>
                                        </select>
                                    <div id="error-perihal"></div>
                                </div>
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                                        required>
                                    <div id="error-tanggal"></div>
                                </div>
                            </div>

                            {{-- Asal Surat --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="asal_surat">Asal Surat</label>
                                    <input type="text" name="asal_surat" id="asal_surat" class="form-control"
                                        placeholder="Masukkan Asal Surat" required>
                                    <div id="error-asal_surat"></div>
                                </div>
                            </div>

                            {{-- Nomor --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nomor">Nomor</label>
                                    <input type="text" name="nomor" id="nomor" class="form-control"
                                        placeholder="Masukkan Nomor" required>
                                    <div id="error-nomor"></div>
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Masukkan Keterangan" required></textarea>
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
    <div id="modal-surat-update" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-surat-updateLabel"
        aria-hidden="true">
        <form action="{{ route('surat.update') }}" method="post" id="form-surat-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-surat-updateLabel">Form Surat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        {{-- Perihal --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-perihal">Perihal</label>
                                        <select name="perihal" id="update-perihal" class="form-control" required>
                                            <option value="" selected disabled>Pilih Perihal</option>
                                            <option value="Surat Masuk">Surat Masuk</option>
                                            <option value="Surat Keluar">Surat Keluar</option>
                                        </select>
                                    <div id="error-update-perihal"></div>
                                </div>
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="update-tanggal" class="form-control"
                                        required>
                                    <div id="error-update-tanggal"></div>
                                </div>
                            </div>

                            {{-- Asal Surat --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-asal_surat">Asal Surat</label>
                                    <input type="text" name="asal_surat" id="update-asal_surat" class="form-control"
                                        placeholder="Masukkan Asal Surat" required>
                                    <div id="error-update-asal_surat"></div>
                                </div>
                            </div>

                            {{-- Nomor --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-nomor">Nomor</label>
                                    <input type="text" name="nomor" id="update-nomor" class="form-control"
                                        placeholder="Masukkan Nomor" required>
                                    <div id="error-update-nomor"></div>
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="update-keterangan" class="form-control" placeholder="Masukkan Keterangan" required></textarea>
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
    <script src="{{ asset('js/page/surat/list.js?q=' . Str::random(5)) }}"></script>
@endpush

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
                    @if (rbacCheck('ref_divisi', 2))
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
                                    <th>Divisi</th>
                                    <th>Keterangan</th>
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
    <div id="modal-divisi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-divisiLabel"
        aria-hidden="true">
        <form action="{{ route('divisi.store') }}" method="post" id="form-divisi" autocomplete="off">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-divisiLabel">Form Divisi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Nama --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Divisi" required>
                                    <div id="error-nama"></div>
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
    <div id="modal-divisi-update" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-divisi-updateLabel"
        aria-hidden="true">
        <form action="{{ route('divisi.update') }}" method="post" id="form-divisi-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-divisi-updateLabel">Form Divisi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Nama --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-nama">Nama</label>
                                    <input type="text" name="nama" id="update-nama" class="form-control" placeholder="Masukkan Nama Divisi" required>
                                    <div id="error-update-nama"></div>
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
    <script src="{{ asset('js/page/gmpa/divisi/list.js?q=' . Str::random(5)) }}"></script>
@endpush

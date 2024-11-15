@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

@section('contents')
    {{-- List --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (rbacCheck('program_siar', 2))
                        <div class="row mb-2">
                            <div class="col-sm-12 d-flex justify-content-between">
                                <button type="button" class="btn btn-dark" onclick="history.back()"><i
                                        class="bx bx-arrow-back"></i> Back</button>
                                <button type="button"
                                    class="btn btn-success btn-rounded waves-effect waves-light btn-tambah">
                                    <i class="bx bx-plus-circle mr-1"></i> Tambah
                                </button>
                            </div>
                        </div>
                    @endif
                    {{-- Table --}}
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table class="table table-striped" id="table-data" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>Jenis Program</th>
                                    <th>Nama Program</th>
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
    <div id="modal-ref-program-siar" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-ref-program-siarLabel" aria-hidden="true">
        <form action="{{ route('ref-program-siar.store') }}" method="post" id="form-ref-program-siar" autocomplete="off">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-ref-program-siarLabel">Form Programs</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Jenis Program --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="jenis_program_id">Jenis Program</label>
                                    <select name="jenis_program_id" id="jenis_program_id" class="form-control select2"
                                        required>
                                        <option value="" selected disabled>Pilih Jenis Program</option>
                                        @foreach ($jenis_program as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->jenis }}</option>
                                        @endforeach
                                    </select>
                                    <div id="error-jenis_program_id"></div>
                                </div>
                            </div>

                            {{-- Nama Program --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nama">Nama Program</label>
                                    <input type="text" name="nama" id="nama" class="form-control"
                                        placeholder="Masukkan Nama Program" required>
                                    <div id="error-nama"></div>
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
    <div id="modal-ref-program-siar-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-ref-program-siar-updateLabel" aria-hidden="true">
        <form action="{{ route('ref-program-siar.update') }}" method="post" id="form-ref-program-siar-update"
            autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-ref-program-siar-updateLabel">Form Programs
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Jenis Program --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-jenis_program_id">Jenis Program</label>
                                    <select name="jenis_program_id" id="update-jenis_program_id"
                                        class="form-control select2" required>
                                        <option value="" selected disabled>Pilih Jenis Program</option>
                                        @foreach ($jenis_program as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->jenis }}</option>
                                        @endforeach
                                    </select>
                                    <div id="error-update-jenis_program_id"></div>
                                </div>
                            </div>

                            {{-- Nama Program --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-nama">Nama Program</label>
                                    <input type="text" name="nama" id="update-nama" class="form-control"
                                        placeholder="Masukkan Nama Program" required>
                                    <div id="error-update-nama"></div>
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
    <script src="{{ asset('js/page/program-siar/program/list.js?q=' . Str::random(5)) }}"></script>
@endpush

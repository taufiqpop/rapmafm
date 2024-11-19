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
                                    <th>Key</th>
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
    <div id="modal-ref-jenis-program-siar" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-ref-jenis-program-siarLabel" aria-hidden="true">
        <form action="{{ route('ref-jenis-program-siar.store') }}" method="post" id="form-ref-jenis-program-siar"
            autocomplete="off">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-ref-jenis-program-siarLabel">Form Programs</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Jenis Program --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="jenis">Jenis Program</label>
                                    <input type="text" name="jenis" id="jenis" class="form-control"
                                        placeholder="Masukkan Jenis Program" required>
                                    <div id="error-jenis"></div>
                                </div>
                            </div>

                            {{-- Key --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="key">Key</label>
                                    <input type="text" name="key" id="key" class="form-control"
                                        placeholder="Masukkan Key" required>
                                    <div id="error-key"></div>
                                    <small>*Ini Untuk Flag Di Frontend</small>
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
    <div id="modal-ref-jenis-program-siar-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-ref-jenis-program-siar-updateLabel" aria-hidden="true">
        <form action="{{ route('ref-jenis-program-siar.update') }}" method="post" id="form-ref-jenis-program-siar-update"
            autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-ref-jenis-program-siar-updateLabel">Form Programs
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
                                    <label for="update-jenis">Jenis Program</label>
                                    <input type="text" name="jenis" id="update-jenis" class="form-control"
                                        placeholder="Masukkan Jenis Program" required>
                                    <div id="error-update-jenis"></div>
                                </div>
                            </div>

                            {{-- Key --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-key">Key</label>
                                    <input type="text" name="key" id="update-key" class="form-control"
                                        placeholder="Masukkan Key" required>
                                    <div id="error-update-key"></div>
                                    <small>*Ini Untuk Flag Di Frontend</small>
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
    <script src="{{ asset('js/page/program-siar/jenis/list.js?q=' . Str::random(5)) }}"></script>
@endpush

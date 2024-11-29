@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal'];
@endphp

@section('contents')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('affected'))
                        <div class="alert alert-success" role="alert">
                            Data berhasil disimpan!
                        </div>
                    @endif
                    @if (rbacCheck('otoritas', 2))
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
                                    <th style="width: 5%;">No</th>
                                    <th>Nama Otoritas</th>
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

    <div id="modal-otoritas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-otoritasLabel"
        aria-hidden="true">
        <form action="{{ route('otoritas.store') }}" method="post" id="form-otoritas" autocomplete="off">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-otoritasLabel">Form Otoritas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Otoritas</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Masukkan Nama Otoritas" required>
                            <div id="error-name"></div>
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

    <div id="modal-otoritas-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-otoritas-updateLabel" aria-hidden="true">
        <form action="{{ route('otoritas.update') }}" method="post" id="form-otoritas-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-otoritas-updateLabel">Form Otoritas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="update-name">Nama Otoritas</label>
                            <input type="text" name="name" id="update-name" class="form-control"
                                placeholder="Masukkan Nama Otoritas" required>
                            <div id="error-update-name"></div>
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
    <script src="{{ asset('js/page/administrator/otoritas/list.js?q=' . Str::random(5)) }}"></script>
@endpush

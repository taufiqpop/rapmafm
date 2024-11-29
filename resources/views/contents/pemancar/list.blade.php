@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'leaflet'];
@endphp

@section('contents')
    {{-- List --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (rbacCheck('pemancar', 2))
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
                                    <th>Tanggal</th>
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
    <div id="modal-pemancar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-pemancarLabel"
        aria-hidden="true">
        <form action="{{ route('pemancar.store') }}" method="post" id="form-pemancar" autocomplete="off">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-pemancarLabel">Form Pemancar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                                        placeholder="Masukkan Tanggal" required>
                                    <div id="error-tanggal"></div>
                                </div>
                            </div>

                            {{-- Peta Koordinat --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="create-map">Peta Koordinat</label>
                                    <div id="create-map" style="height: 400px;"></div>
                                </div>
                            </div>

                            {{-- Koordinat --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea name="coordinates" id="create-coordinates" class="form-control" placeholder="-" required readonly></textarea>
                                    <div id="error-coordinates"></div>
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
    <div id="modal-pemancar-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-pemancar-updateLabel" aria-hidden="true">
        <form action="{{ route('pemancar.update') }}" method="post" id="form-pemancar-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-pemancar-updateLabel">Form Pemancar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="update-tanggal" class="form-control"
                                        placeholder="Masukkan Tanggal" required>
                                    <div id="error-update-tanggal"></div>
                                </div>
                            </div>

                            {{-- Peta Koordinat --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="update-map">Peta Koordinat</label>
                                    <div id="update-map" style="height: 400px"></div>
                                </div>
                            </div>

                            {{-- Koordinat --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea name="coordinates" id="update-coordinates" class="form-control" placeholder="-" required readonly></textarea>
                                    <div id="error-update-coordinates"></div>
                                </div>
                            </div>

                            <div class="col-lg-8 mt-2">
                                <button type="button" class="btn btn-dark" onclick="clearCoordinates()"><i
                                        class="bx bx-trash-alt"></i> Clear Koordinat</button>
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
    <script src="{{ asset('js/page/pemancar/list.js?q=' . Str::random(5)) }}"></script>
@endpush

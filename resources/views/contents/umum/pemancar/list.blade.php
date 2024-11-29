@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'leaflet'];
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
@endpush

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
                                    <th>Coordinate Type</th>
                                    <th>Daerah</th>
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="update-tanggal" class="form-control"
                                        placeholder="Masukkan Tanggal" required>
                                    <div id="error-update-tanggal"></div>
                                </div>
                            </div>

                            {{-- Tipe Koordinat --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="update-coordinate_type">Tipe Koordinat<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="coordinate_type" id="update-coordinate_type"
                                        class="form-control" placeholder="Masukkan Tipe Koordinat" required readonly>
                                    <div id="error-update-coordinate_type"></div>
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

                        <hr>
                        <div class="row">
                            {{-- Daerah --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="daerah-section">
                                        <h6>Daerah</h6>
                                        <button type="button" class="btn btn-sm btn-success add-daerah"><i
                                                class="bx bx-plus"></i> Tambah Daerah</button>
                                        <div id="daerah-fields-update" class="mt-2"></div>
                                    </div>
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                                        placeholder="Masukkan Tanggal" required>
                                    <div id="error-tanggal"></div>
                                </div>
                            </div>

                            {{-- Tipe Koordinat --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="coordinate_type">Tipe Koordinat<span class="text-danger">*</span></label>
                                    <input type="text" name="coordinate_type" id="coordinate_type"
                                        class="form-control" placeholder="Masukkan Tipe Koordinat" value="MultiPolygon"
                                        required readonly>
                                    <div id="error-coordinate_type"></div>
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

                        <hr>
                        <div class="row">
                            {{-- Daerah --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="daerah-section">
                                        <h6>Daerah</h6>
                                        <button type="button" class="btn btn-sm btn-success add-daerah"><i
                                                class="bx bx-plus"></i> Tambah Daerah</button>
                                        <div id="daerah-fields" class="mt-2"></div>
                                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="{{ asset('js/page/umum/pemancar/list.js?q=' . Str::random(5)) }}"></script>
@endpush

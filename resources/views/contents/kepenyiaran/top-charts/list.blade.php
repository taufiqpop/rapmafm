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
                    @if (rbacCheck('top_charts', 2))
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
                                    <th>Versi</th>
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
    <div id="modal-top-charts" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-top-chartsLabel"
        aria-hidden="true">
        <form action="{{ route('top-charts.store') }}" method="post" id="form-top-charts" autocomplete="off">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-top-chartsLabel">Form Top Charts</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Versi --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="versi">Versi</label>
                                    <input type="text" name="versi" id="versi" class="form-control"
                                        placeholder="Masukkan Versi" required>
                                    <div id="error-versi"></div>
                                </div>
                            </div>

                            {{-- Link --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="link">Link</label>
                                    <input type="text" name="link" id="link" class="form-control"
                                        placeholder="Masukkan Link" required>
                                    <div id="error-link"></div>
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
    <div id="modal-top-charts-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-top-charts-updateLabel" aria-hidden="true">
        <form action="{{ route('top-charts.update') }}" method="post" id="form-top-charts-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-top-charts-updateLabel">Form Top Charts</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Versi --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-versi">Versi</label>
                                    <input type="text" name="versi" id="update-versi" class="form-control"
                                        placeholder="Masukkan Versi" required>
                                    <div id="error-update-versi"></div>
                                </div>
                            </div>

                            {{-- Link --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-link">Link</label>
                                    <input type="text" name="link" id="update-link" class="form-control"
                                        placeholder="Masukkan Link" required>
                                    <div id="error-update-link"></div>
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
    <script src="{{ asset('js/page/kepenyiaran/top-charts/list.js?q=' . Str::random(5)) }}"></script>
@endpush

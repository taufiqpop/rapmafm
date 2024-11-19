@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

@section('contents')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (rbacCheck('manajemen_menu', 2))
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
                                    <th style="width: 5%;">#</th>
                                    <th>Nama Menu</th>
                                    <th>Induk Menu</th>
                                    <th>Ikon</th>
                                    <th>Tautan</th>
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

    <div id="modal-menu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-menuLabel"
        aria-hidden="true">
        <form action="{{ route('manajemen-menu.store') }}" method="post" id="form-menu" autocomplete="off">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-menuLabel">Form Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Menu</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Masukkan Nama Menu" required>
                            <div id="error-name"></div>
                        </div>
                        <div class="form-group">
                            <label for="link">Tautan Menu</label>
                            <input type="text" name="link" id="link" class="form-control"
                                placeholder="Masukkan Tautan">
                            <div id="error-link"></div>
                        </div>
                        <div class="form-group">
                            <label for="">Jenis Menu</label>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="type-main" name="menu_type" class="custom-control-input"
                                            value="main">
                                        <label class="custom-control-label" for="type-main">Menu Utama</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="type-child" name="menu_type" class="custom-control-input"
                                            value="child">
                                        <label class="custom-control-label" for="type-child">Submenu</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="div-menu-type div-main">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-icons" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nama Ikon</th>
                                            <th class="text-center">Tampilan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (icons() as $key => $value)
                                            <tr>
                                                <td class="text-center" style="width: 30%;"><i
                                                        class="{{ $value }} fa-2x text-primary pilih-icon"
                                                        data-icon_name="{{ $value }}"></i></td>
                                                <td><span class="pilih-icon" data-icon_name="{{ $value }}">
                                                        {{ $value }}
                                                    </span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <label for="icon">Ikon Menu</label>
                                <input type="text" name="icon" id="icon" class="form-control"
                                    placeholder="Pilih Ikon Menu di Tabel Di Atas" readonly>
                                <div id="error-icon"></div>
                            </div>
                        </div>
                        <div class="div-menu-type div-child" style="display: none">
                            <div class="form-group">
                                <label for="parent_id">Nama Menu Utama</label>
                                <select name="parent_id" id="parent_id" class="form-control" style="width: 100%;">
                                    <option value="" selected disabled>Pilih Menu Utama</option>
                                </select>
                                <div id="error-parent_id"></div>
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

    <div id="modal-update-menu" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-update-menuLabel" aria-hidden="true">
        <form action="{{ route('manajemen-menu.update') }}" method="post" id="form-update-menu" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-update-menuLabel">Form Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="update-name">Nama Menu</label>
                            <input type="text" name="name" id="update-name" class="form-control"
                                placeholder="Masukkan Nama Menu" required>
                            <div id="error-update-name"></div>
                        </div>
                        <div class="form-group">
                            <label for="update-link">Tautan Menu</label>
                            <input type="text" name="link" id="update-link" class="form-control"
                                placeholder="Masukkan Tautan">
                            <div id="error-update-link"></div>
                        </div>
                        <div class="form-group">
                            <label for="">Jenis Menu</label>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="type-update-main" name="menu_type"
                                            class="custom-control-input" value="main">
                                        <label class="custom-control-label" for="type-update-main">Menu Utama</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="type-update-child" name="menu_type"
                                            class="custom-control-input" value="child">
                                        <label class="custom-control-label" for="type-update-child">Submenu</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="div-menu-type div-main">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-icons" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nama Ikon</th>
                                            <th class="text-center">Tampilan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (icons() as $key => $value)
                                            <tr>
                                                <td class="text-center" style="width: 30%;"><i
                                                        class="{{ $value }} fa-2x text-primary pilih-icon"
                                                        data-icon_name="{{ $value }}"></i></td>
                                                <td><span class="pilih-icon" data-icon_name="{{ $value }}">
                                                        {{ $value }}
                                                    </span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <label for="update-icon">Ikon Menu</label>
                                <input type="text" name="icon" id="update-icon" class="form-control"
                                    placeholder="Pilih Ikon Menu di Tabel Di Atas" readonly>
                                <div id="error-update-icon"></div>
                            </div>
                        </div>
                        <div class="div-menu-type div-child" style="display: none">
                            <div class="form-group">
                                <label for="update-parent_id">Nama Menu Utama</label>
                                <select name="parent_id" id="update-parent_id" class="form-control"
                                    style="width: 100%;">
                                    <option value="" selected disabled>Pilih Menu Utama</option>
                                </select>
                                <div id="error-update-parent_id"></div>
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
    <script src="{{ asset('js/page/menu/list.js?q=' . Str::random(5)) }}"></script>
@endpush

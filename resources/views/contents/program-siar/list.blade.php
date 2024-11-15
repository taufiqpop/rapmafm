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
                            <div class="col-sm-12">
                                <div class="text-sm-right">
                                    <a href="{{ route('ref-jenis-program-siar') }}"
                                        class="btn btn-primary btn-rounded waves-effect waves-light"><i
                                            class="bx bx-package mr-1"></i> Jenis Program Siar</a>
                                    <a href="{{ route('ref-program-siar') }}"
                                        class="btn btn-info btn-rounded waves-effect waves-light"><i
                                            class="bx bx-radio mr-1"></i> Daftar Program Siar</a>
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
                                    <th>Jenis Program</th>
                                    <th>Nama Program</th>
                                    <th>Tahun</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Artwork</th>
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
    <div id="modal-program-siar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-program-siarLabel"
        aria-hidden="true">
        <form action="{{ route('program-siar.store') }}" method="post" id="form-program-siar" autocomplete="off">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-program-siarLabel">Form Program Siar</h5>
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
                                    <label for="program_id">Nama Program</label>
                                    <select name="program_id" id="program_id" class="form-control select2" required>
                                        <option value="" selected disabled>Pilih Program Siar</option>
                                    </select>
                                    <div id="error-program_id"></div>
                                </div>
                            </div>

                            {{-- Tahun --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <input type="number" name="tahun" id="tahun" class="form-control"
                                        placeholder="Masukkan Tahun" required>
                                    <div id="error-tahun"></div>
                                </div>
                            </div>

                            {{-- Order --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="order">Order</label>
                                    <input type="number" name="order" id="order" class="form-control"
                                        placeholder="Masukkan Order" required>
                                    <div id="error-order"></div>
                                </div>
                            </div>

                            {{-- Link --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="link">Link</label>
                                    <input type="text" name="link" id="link" class="form-control"
                                        placeholder="Masukkan Order" required>
                                    <div id="error-link"></div>
                                </div>
                            </div>

                            {{-- Artwork --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="image">Artwork</label>
                                    <input type="file" name="image" id="image" class="form-control-file images"
                                        accept="image/*">
                                    <div id="error-image"></div>

                                    {{-- Preview Images --}}
                                    <div id="image-preview-container">
                                        <img class="images-preview"
                                            style="max-width: 100%; margin-top: 10px; display: none;">
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

    {{-- Update --}}
    <div id="modal-program-siar-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-program-siar-updateLabel" aria-hidden="true">
        <form action="{{ route('program-siar.update') }}" method="post" id="form-program-siar-update"
            autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-program-siar-updateLabel">Form Program Siar
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
                                    <label for="update-program_id">Nama Program</label>
                                    <select name="program_id" id="update-program_id" class="form-control select2"
                                        required>
                                        <option value="" selected disabled>Pilih Program Siar</option>
                                    </select>
                                    <div id="error-update-program_id"></div>
                                </div>
                            </div>

                            {{-- Tahun --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-tahun">Tahun</label>
                                    <input type="number" name="tahun" id="update-tahun" class="form-control"
                                        placeholder="Masukkan Tahun" required>
                                    <div id="error-update-tahun"></div>
                                </div>
                            </div>

                            {{-- Order --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-order">Order</label>
                                    <input type="number" name="order" id="update-order" class="form-control"
                                        placeholder="Masukkan Order" required>
                                    <div id="error-update-order"></div>
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

                            {{-- Artwork --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-image">Artwork</label>
                                    <input type="file" name="image" id="update-image"
                                        class="form-control-file images" accept="image/*">
                                    <small>*Kosongkan Jika Tidak Ingin Mengganti Artwork</small>
                                    <div id="error-update-image"></div>

                                    {{-- Preview Images --}}
                                    <div id="image-preview-container">
                                        <img class="images-preview"
                                            style="max-width: 100%; margin-top: 10px; display: none;">
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
    <script src="{{ asset('js/page/program-siar/list.js?q=' . Str::random(5)) }}"></script>
@endpush

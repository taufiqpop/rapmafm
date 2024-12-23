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

                    {{-- Filter --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="filter-jenis-program">Jenis Program</label>
                            <select id="filter-jenis-program" class="form-control">
                                <option value="" selected>Semua Jenis Program</option>
                                @foreach ($jenis_program as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="filter-program-siar">Nama Program Siar</label>
                            <select id="filter-program-siar" class="form-control">
                                <option value="" selected>Semua Program Siar</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="filter-tahun">Tahun</label>
                            <select id="filter-tahun" class="form-control">
                                <option value="" selected>Semua Tahun</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year->year }}">{{ $year->year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if (rbacCheck('podcast', 2))
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
                                    <th>Jenis Program</th>
                                    <th>Nama Program</th>
                                    <th>Judul</th>
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
    <div id="modal-podcast" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-podcastLabel"
        aria-hidden="true">
        <form action="{{ route('podcast.store') }}" method="post" id="form-podcast" autocomplete="off">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-podcastLabel">Form Podcast</h5>
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

                            {{-- Judul --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="judul">Judul</label>
                                    <input type="text" name="judul" id="judul" class="form-control"
                                        placeholder="Masukkan Judul" required>
                                    <div id="error-judul"></div>
                                </div>
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                                        placeholder="Masukkan Tanggal" required>
                                    <div id="error-tanggal"></div>
                                </div>
                            </div>

                            {{-- Link --}}
                            <div class="col-6">
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
    <div id="modal-podcast-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-podcast-updateLabel" aria-hidden="true">
        <form action="{{ route('podcast.update') }}" method="post" id="form-podcast-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-podcast-updateLabel">Form Podcast
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

                            {{-- Judul --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-judul">Judul</label>
                                    <input type="text" name="judul" id="update-judul" class="form-control"
                                        placeholder="Masukkan Judul" required>
                                    <div id="error-update-judul"></div>
                                </div>
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="update-tanggal" class="form-control"
                                        placeholder="Masukkan Tanggal" required>
                                    <div id="error-update-tanggal"></div>
                                </div>
                            </div>

                            {{-- Link --}}
                            <div class="col-6">
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
    <script src="{{ asset('js/page/kepenyiaran/podcast/list.js?q=' . Str::random(5)) }}"></script>
@endpush

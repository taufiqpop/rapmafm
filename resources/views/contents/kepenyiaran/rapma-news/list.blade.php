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
                    @if (rbacCheck('rapma_news', 2))
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
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Photo</th>
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
    <div id="modal-rapma-news" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-rapma-newsLabel"
        aria-hidden="true">
        <form action="{{ route('rapma-news.store') }}" method="post" id="form-rapma-news" autocomplete="off">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-rapma-newsLabel">Form Rapma News</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

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
                                    <input type="datetime-local" name="tanggal" id="tanggal" class="form-control"
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

                            {{-- Deskripsi --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" rows="5" id="deskripsi" class="form-control" placeholder="Masukkan Deskripsi" required></textarea>
                                    <div id="error-deskripsi"></div>
                                </div>
                            </div>

                            {{-- Photo --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="image">Photo</label>
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
    <div id="modal-rapma-news-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-rapma-news-updateLabel" aria-hidden="true">
        <form action="{{ route('rapma-news.update') }}" method="post" id="form-rapma-news-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-rapma-news-updateLabel">Form Rapma News
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
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
                                    <input type="datetime-local" name="tanggal" id="update-tanggal" class="form-control"
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

                            {{-- Deskripsi --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" rows="5" id="update-deskripsi" class="form-control"
                                        placeholder="Masukkan Deskripsi" required></textarea>
                                    <div id="error-update-deskripsi"></div>
                                </div>
                            </div>

                            {{-- Photo --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-image">Photo</label>
                                    <input type="file" name="image" id="update-image"
                                        class="form-control-file images" accept="image/*">
                                    <small>*Kosongkan Jika Tidak Ingin Mengganti Photo</small>
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

    {{-- Modal Deskripsi --}}
    <div class="modal fade" id="deskripsiModal" tabindex="-1" aria-labelledby="deskripsiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deskripsiModalLabel">Deskripsi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="deskripsiContent"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/page/kepenyiaran/rapma-news/list.js?q=' . Str::random(5)) }}"></script>
@endpush

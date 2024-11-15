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
                    @if (rbacCheck('events', 2))
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
                                    <th>Jenis Event</th>
                                    <th>Nama Event</th>
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
    <div id="modal-events" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-eventsLabel"
        aria-hidden="true">
        <form action="{{ route('events.store') }}" method="post" id="form-events" autocomplete="off">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-eventsLabel">Form Events</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            {{-- Jenis Event --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="jenis_event">Jenis Event</label>
                                    <select name="jenis_event" id="jenis_event" class="form-control" required>
                                        <option value="" selected disabled>Pilih Jenis Event</option>
                                        <option value="RAPMADAY">RAPMADAY</option>
                                        <option value="RAPMAFEST">RAPMAFEST</option>
                                        <option value="OPEN RECRUITMENT">OPEN RECRUITMENT</option>
                                    </select>
                                    <div id="error-jenis_event"></div>
                                </div>
                            </div>

                            {{-- Nama Event --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nama_event">Nama Event</label>
                                    <input type="text" name="nama_event" id="nama_event" class="form-control"
                                        placeholder="Masukkan Nama Event" required>
                                    <div id="error-nama_event"></div>
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
    <div id="modal-events-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-events-updateLabel" aria-hidden="true">
        <form action="{{ route('events.update') }}" method="post" id="form-events-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-events-updateLabel">Form Events
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Jenis Event --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-jenis_event">Jenis Event</label>
                                    <select name="jenis_event" id="update-jenis_event" class="form-control" required>
                                        <option value="" selected disabled>Pilih Jenis Event</option>
                                        <option value="RAPMADAY">RAPMADAY</option>
                                        <option value="RAPMAFEST">RAPMAFEST</option>
                                        <option value="OPEN RECRUITMENT">OPEN RECRUITMENT</option>
                                    </select>
                                    <div id="error-update-jenis_event"></div>
                                </div>
                            </div>

                            {{-- Nama Event --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-nama_event">Nama Event</label>
                                    <input type="text" name="nama_event" id="update-nama_event" class="form-control"
                                        placeholder="Masukkan Nama Event" required>
                                    <div id="error-update-nama_event"></div>
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
    <script src="{{ asset('js/page/events/list.js?q=' . Str::random(5)) }}"></script>
@endpush

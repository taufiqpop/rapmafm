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
                    @if (rbacCheck('pesan', 2))
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
                                    <th>Nama Pengirim</th>
                                    <th>Email Pengirim</th>
                                    <th>Subject</th>
                                    <th>Message</th>
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
    <div id="modal-pesan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-pesanLabel"
        aria-hidden="true">
        <form action="{{ route('pesan.store') }}" method="post" id="form-pesan" autocomplete="off">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-pesanLabel">Form Pesan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Nama Pengirim --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nama">Nama Pengirim</label>
                                    <input type="text" name="nama" id="nama" class="form-control"
                                        placeholder="Masukkan Nama Pengirim" required>
                                    <div id="error-nama"></div>
                                </div>
                            </div>

                            {{-- Email Pengirim --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">Email Pengirim</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Masukkan Email Pengirim" required>
                                    <div id="error-email"></div>
                                </div>
                            </div>

                            {{-- Subject --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control"
                                        placeholder="Masukkan Subject" required>
                                    <div id="error-subject"></div>
                                </div>
                            </div>

                            {{-- Message --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea name="message" id="message" class="form-control" placeholder="Masukkan Message" required></textarea>
                                    <div id="error-message"></div>
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
    <div id="modal-pesan-update" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-pesan-updateLabel"
        aria-hidden="true">
        <form action="{{ route('pesan.update') }}" method="post" id="form-pesan-update" autocomplete="off">
            <input type="hidden" name="id" id="update-id">
            @method('PATCH')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-pesan-updateLabel">Form Pesan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Nama Pengirim --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-nama">Nama Pengirim</label>
                                    <input type="text" name="nama" id="update-nama" class="form-control"
                                        placeholder="Masukkan Nama Pengirim" required>
                                    <div id="error-update-nama"></div>
                                </div>
                            </div>

                            {{-- Email Pengirim --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-email">Email Pengirim</label>
                                    <input type="email" name="email" id="update-email" class="form-control"
                                        placeholder="Masukkan Email Pengirim" required>
                                    <div id="error-update-email"></div>
                                </div>
                            </div>

                            {{-- Subject --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-subject">Subject</label>
                                    <input type="text" name="subject" id="update-subject" class="form-control"
                                        placeholder="Masukkan Subject" required>
                                    <div id="error-update-subject"></div>
                                </div>
                            </div>

                            {{-- Message --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="update-message">Message</label>
                                    <textarea name="message" id="update-message" class="form-control" placeholder="Masukkan Message" required></textarea>
                                    <div id="error-update-message"></div>
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
    <script src="{{ asset('js/page/pesan/list.js?q=' . Str::random(5)) }}"></script>
@endpush

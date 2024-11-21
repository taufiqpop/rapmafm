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
                    @if (rbacCheck('pengguna', 2))
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
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Roles</th>
                                    <th>Status</th>
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
    <div id="modal-pengguna" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-penggunaLabel"
        aria-hidden="true">
        <form action="{{ route('users.store') }}" method="post" id="form-pengguna" autocomplete="off">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-penggunaLabel">Form Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Masukkan Nama Lengkap" required>
                            <div id="error-name"></div>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control"
                                placeholder="Masukkan Username" required>
                            <div id="error-username"></div>
                        </div>
                        <div class="form-group">
                            <label for="password">Kata Sandi</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Masukkan Kata Sandi" required>
                            <div id="error-password"></div>
                        </div>
                        <div class="form-group">
                            <label for="confirmation_password">Konfirmasi Kata Sandi</label>
                            <input type="password" name="confirmation_password" id="confirmation_password"
                                class="form-control" placeholder="Masukkan Konfirmasi Kata Sandi" required>
                            <div id="error-confirmation_password"></div>
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
    <div id="modal-pengguna-update" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-pengguna-updateLabel" aria-hidden="true">
        <form action="{{ route('users.update') }}" method="post" id="form-pengguna-update" autocomplete="off">
            @method('PATCH')
            <input type="hidden" name="id" id="update-id">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-pengguna-updateLabel">Form Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="update-name">Nama Lengkap</label>
                            <input type="text" name="name" id="update-name" class="form-control"
                                placeholder="Masukkan Nama Lengkap" required>
                            <div id="error-update-name"></div>
                        </div>
                        <div class="form-group">
                            <label for="update-username">Username</label>
                            <input type="text" name="username" id="update-username" class="form-control"
                                placeholder="Masukkan Username" required>
                            <div id="error-update-username"></div>
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

    {{-- Roles --}}
    <div id="modal-update-role" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal-update-roleLabel" aria-hidden="true">
        <form action="{{ route('users.update.roles') }}" method="post" id="form-update-role" autocomplete="off">
            @method('PATCH')
            <input type="hidden" name="id" id="update-role-user-id">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-update-roleLabel">Peran Pengguna : <b
                                class="user-name"></b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                @foreach ($roles as $role)
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input checkbox-role"
                                                name="role_id[]" id="role-{{ $role->id }}"
                                                value="{{ $role->id }}">
                                            <label class="custom-control-label"
                                                for="role-{{ $role->id }}">{{ $role->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
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
    <script src="{{ asset('js/page/pengguna/list.js?q=' . Str::random(5)) }}"></script>
@endpush

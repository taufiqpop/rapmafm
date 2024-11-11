<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>RAPMA FM | Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="RAPMA FM" name="description" />
    <meta content="alief" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/logo/afel_putih.png">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<div>
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-xl-8">
                <div class="auth-full-bg pt-lg-5 p-4">
                    <div class="w-100">
                        <div class="bg-overlay"></div>
                        <div class="d-flex h-100 flex-column">
                            <div class="p-4 mt-auto mb-auto">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="text-center"
                                            style="height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                            <h4 class="mb-2">
                                                <img src="assets/images/logo/afel_hitam.png" class="img-fluid mb-4"
                                                    style="width: 300px; height: auto;">
                                                <br>
                                                <i class="bx bxs-quote-alt-left text-primary h1 align-middle mr-3"></i>
                                                <span class="text-primary">Assessment For Economics Learning
                                                    (RAPMA FM)</span>
                                                <i class="bx bxs-quote-alt-right text-primary h1 align-middle ml-3"></i>
                                            </h4>
                                            <p class="font-size-16 mb-5 mt-2 text-center text-capitalize">Platform untuk
                                                membantu guru ekonomi dalam melakukan penilaian pembelajaran <br>dengan
                                                dukungan perangkat penilaian yang <br>Sistematis, Produktif,
                                                Profesional.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->

            <div class="col-xl-4">
                <div class="auth-full-page-content p-md-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="my-auto">
                                <div>
                                    <h5 class="text-primary">Register !</h5>
                                    <p class="text-muted">Sign Up to create account</p>
                                </div>

                                <div class="mt-4">
                                    @if (session('message'))
                                        <div class="alert alert-danger">{{ session('message') }}</div>
                                    @endif
                                    <form class="form-horizontal" action="{{ route('register') }}" autocomplete="off"
                                        method="post">
                                        @csrf

                                        <div class="form-group">
                                            <input type="text" class="form-control" id="role_id" name="role_id"
                                                value=2 hidden>
                                            <label for="name">Nama</label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                name="name" value="{{ old('name') }}" placeholder="Masukkan Nama"
                                                autofocus>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text"
                                                class="form-control @error('username') is-invalid @enderror"
                                                id="username" name="username" value="{{ old('username') }}"
                                                placeholder="Masukkan Username" autofocus>
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" value="{{ old('email') }}" placeholder="Masukkan Email"
                                                autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Kata Sandi <span
                                                    style="color: red;font-size: smaller;font-family: 'serif';">
                                                    *</span></label>
                                            <div class="input-group">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password" placeholder="Masukkan Kata Sandi"
                                                    required>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary"
                                                        id="showPasswordToggle">
                                                        <i class="bx bx-show"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <label><span
                                                    style="color: red;font-size: smaller;font-family: 'serif';">*minimal
                                                    8 karakter dan mengandung huruf dan angka</span></label>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="password_confirmation">Konfirmasi Kata Sandi <span
                                                    style="color: red;font-size: smaller;font-family: 'serif';">
                                                    *</span></label>
                                            <div class="input-group">
                                                <input type="password"
                                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                                    id="password_confirmation" name="password_confirmation"
                                                    placeholder="Konfirmasi Kata Sandi" required>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary"
                                                        id="showPasswordConfirmToggle">
                                                        <i class="bx bx-show"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <label><span
                                                    style="color: red;font-size: smaller;font-family: 'serif';">*Harus
                                                    sama dengan Password</span></label>
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mt-3">
                                            <button class="btn btn-primary btn-block waves-effect waves-light"
                                                type="submit">Register</button>
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ route('login') }}"
                                                class="btn btn-danger btn-block waves-effect waves-light">Batal</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>

    {{-- js untuk show password --}}
    <script>
        document.getElementById('showPasswordToggle').addEventListener('click', function() {
            var passwordField = document.getElementById('password');
            var fieldType = passwordField.getAttribute('type');

            // Toggle password visibility
            if (fieldType === 'password') {
                passwordField.setAttribute('type', 'text');
            } else {
                passwordField.setAttribute('type', 'password');
            }
        });

        document.getElementById('showPasswordConfirmToggle').addEventListener('click', function() {
            var passwordField = document.getElementById('password_confirmation');
            var fieldType = passwordField.getAttribute('type');

            // Toggle password visibility
            if (fieldType === 'password') {
                passwordField.setAttribute('type', 'text');
            } else {
                passwordField.setAttribute('type', 'password');
            }
        });
    </script>

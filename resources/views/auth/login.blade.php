<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>RAPMA FM | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="RAPMA FM" name="description" />
    <meta content="alief" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/logo/afel_putih.png">

    <!-- Bootstrap Css -->
    <link href="{{ config('app.theme') }}assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ config('app.theme') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ config('app.theme') }}assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

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
                                                <span class="text-primary">RAPMA FM</span>
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
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue to RAPMA FM</p>
                                </div>

                                <div class="mt-4">
                                    @if (session('message'))
                                        <div class="alert alert-danger">{{ session('message') }}</div>
                                    @endif
                                    <form class="form-horizontal" action="{{ route('login') }}" autocomplete="off"
                                        method="post">
                                        @csrf

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
                                            <label for="password">Kata Sandi</label>
                                            <div class="input-group">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password" value="{{ old('password') }}"
                                                    placeholder="Masukkan Kata Sandi">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary"
                                                        id="showPasswordToggle">
                                                        <i class="bx bx-show"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn btn-primary btn-block waves-effect waves-light"
                                                type="submit">Masuk</button>
                                        </div>

                                        <div class="mt-2">
                                            <a href="{{ route('register') }}"
                                                class="btn btn-info btn-block waves-effect waves-light"
                                                type="submit">Daftar</a>
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
    </script>

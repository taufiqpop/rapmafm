<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Skote</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Skote" name="description" />
    <meta content="alief" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-soft-primary">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Selamat Datang !</h5>
                                        <p>Masuk untuk melanjutkan.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ asset('assets/images/profile-img.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ asset('assets/images/logo.svg') }}" alt=""
                                                class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                @if (Session::has('error-msg'))
                                    <div class="alert alert-danger" role="alert">
                                        @php
                                            Session::get('error-msg', 'default');
                                        @endphp
                                    </div>
                                @endif

                                @if (session('message'))
                                    <div class="alert alert-danger">{{ session('message') }}</div>
                                @endif
                                <form class="form-horizontal" action="{{ route('login') }}" autocomplete="off"
                                    method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text"
                                            class="form-control @error('username') is-invalid @enderror" id="username"
                                            name="username" value="{{ old('username') }}"
                                            placeholder="Masukkan Username" autofocus>
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        {{-- <div class="float-right">
                                            <a href="auth-recoverpw-2.html" class="text-muted">Forgot
                                                password?</a>
                                        </div> --}}
                                        <label for="password">Kata Sandi</label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" value="{{ old('password') }}"
                                                placeholder="Masukkan Kata Sandi">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary" id="show"><i
                                                        class="bx bx-show"></i></button>
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
                                    <div>
                                        <label>Anda belum memiliki akun? <a href="{{ route('register') }}" class="btn btn-warning btn-sm mt-2" style="padding: 1px 2px; font-size: 12px;"><i
                                            class="fas fa-user"></i> Daftar</a></label>
                                        </div>
                                        <div center>
                                            
                                        </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-4 mt-md-5 text-center">
                        <p class="mb-0">©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Skote
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ config('app.theme') }}assets/libs/jquery/jquery.min.js"></script>
    <script src="{{ config('app.theme') }}assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ config('app.theme') }}assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="{{ config('app.theme') }}assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ config('app.theme') }}assets/libs/node-waves/waves.min.js"></script>

    <!-- App js -->
    <script src="{{ config('app.theme') }}assets/js/app.js"></script>
    <script>
        let show = false;
        $('#show').on('click', function() {
            if (show == false) {
                $('#password').attr('type', 'text');
                show = true;
            } else {
                $('#password').attr('type', 'password');
                show = false;
            }
        })
    </script>
</body>

</html>

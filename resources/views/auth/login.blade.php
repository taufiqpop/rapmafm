<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>RAPMA FM | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="RAPMA FM" name="description" />
    <meta content="Taufiq Pop" name="author" />

    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="{{ config('app.theme') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ config('app.theme') }}assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ config('app.theme') }}assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
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
                                                    <img src="assets/images/logo/RapmaFM.png" class="img-fluid mb-4"
                                                        style="width: 300px; height: auto;">
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Login --}}
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

                                            {{-- Username --}}
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

                                            {{-- Passwords --}}
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

                                            {{-- Button Login --}}
                                            <div class="mt-3">
                                                <button class="btn btn-primary btn-block waves-effect waves-light"
                                                    type="submit">Login</button>
                                            </div>

                                            {{-- Button Register --}}
                                            <div class="mt-2">
                                                <a href="{{ route('register') }}"
                                                    class="btn btn-info btn-block waves-effect waves-light"
                                                    type="submit">Register</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SWAL --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            </script>
        @endif
        <script>
            // Show Password Toggle
            document.getElementById('showPasswordToggle').addEventListener('click', function() {
                let passwordField = document.getElementById('password');
                let fieldType = passwordField.getAttribute('type');

                if (fieldType === 'password') {
                    passwordField.setAttribute('type', 'text');
                } else {
                    passwordField.setAttribute('type', 'password');
                }
            });
        </script>
</body>

</html>

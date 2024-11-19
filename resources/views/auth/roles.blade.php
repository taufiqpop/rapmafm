<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Check Access</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Rapma FM" name="description" />
    <meta content="Taufiq Pop" name="author" />

    <link rel="shortcut icon" href="{{ config('app.theme') }}assets/images/favicon.ico">
    <link href="{{ config('app.theme') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ config('app.theme') }}assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ config('app.theme') }}assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
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
                                        <h5 class="text-primary">Pilih Peran Anda!</h5>
                                        <p>Peran yang dipilih akan aktif!</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ config('app.theme') }}assets/images/RapmaFM.png" alt=""
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="{{ route('rapmafm') }}" target="_blank">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ config('app.theme') }}assets/images/logo/RapmaFM_Header.png"
                                                alt="" class="rounded-circle" height="75">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" action="{{ route('choose-role') }}" method="post"
                                    id="form-choose-role">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Crypt::encrypt($user->id) }}">
                                    <div class="user-thumb text-center mb-4">
                                        <img src="{{ asset('img/user_icon.png') }}"
                                            class="rounded-circle img-thumbnail avatar-md" alt="thumbnail">
                                        <h5 class="font-size-15 mt-3">
                                            <?= $user->name ?>
                                        </h5>
                                    </div>
                                    @if (!empty($user->roles))
                                        <div class="form-group">
                                            <label for="role_id">Peran</label>
                                            <select name="role_id" id="role_id" class="form-control">
                                                <option value="" selected disabled>Pilih Peran</option>
                                                @foreach ($user->roles as $role)
                                                    <option value="{{ Crypt::encrypt($role->id) }}">
                                                        {{ Str::ucfirst($role->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <div class="alert alert-danger" role="alert">
                                            Anda belum memiliki hak akses untuk masuk kedalam sistem. Hubungi admin
                                            untuk informasi lebih lanjut!
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <div>
                            <p>Bukan Anda? <a href="{{ route('logout') }}" class="font-weight-medium text-primary"
                                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    Kembali ke halaman login </a> </p>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ config('app.theme') }}assets/libs/jquery/jquery.min.js"></script>
    <script src="{{ config('app.theme') }}assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ config('app.theme') }}assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="{{ config('app.theme') }}assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ config('app.theme') }}assets/libs/node-waves/waves.min.js"></script>

    <!-- App JS -->
    <script src="{{ config('app.theme') }}assets/js/app.js"></script>
    <script src="{{ asset('js/page/auth/chooseRole.js') }}"></script>
</body>

</html>

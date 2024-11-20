<!DOCTYPE html>

{{-- Teknisi On Air 2021 (Taufiq Pop) --}}
{{-- Teknisi On Air 2022 (Hernawan Vano) --}}
{{-- Teknisi 2023 (Erwin Saputro) --}}
{{-- Teknisi 2024 (Juliandre Sukma ) --}}

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    {{-- Google Fonts --}}
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|
    Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,
    700i"
        rel="stylesheet">

    {{-- CSS --}}
    <link href="{{ asset('assets/vendor/css/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/css/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/css/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/css/glightbox/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/css/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    {{-- Main CSS --}}
    <link href="{{ asset('assets/vendor/css/style.css') }}" rel="stylesheet">
</head>

<body>
    {{-- Mobile Nav Toggle Button --}}
    <i class="bi bi-list mobile-nav-toggle"></i>

    {{-- Header --}}
    <header id="header" stats="false">
        <div class="d-flex flex-column">
            <div class="profile">
                <a href="{{ route('login') }}" target="_blank" title="Rapma FM">
                    <img src="{{ asset('assets/images/logo/RapmaFM_Header.png') }}" class="img-fluid rounded-circle">
                </a>
                <h1 class="text-light">{{ $settings->owner }}</h1>
            </div>

            {{-- Navbar --}}
            <nav id="navbar" class="nav-menu navbar">
                <ul>
                    <li><a href="{{ url('#hero') }}" class="nav-link scrollto active"><i class="bx bx-home"></i>
                            <span>Home</span></a></li>
                    <li><a href="{{ url('#structure') }}" class="nav-link scrollto"><i class="bx bx-user"></i>
                            <span>Structure</span></a></li>
                    <li><a href="{{ url('#program') }}" class="nav-link scrollto"><i class="bx bx-microphone"></i>
                            <span>Program</span></a></li>
                    <li><a href="{{ url('#minigames') }}" class="nav-link scrollto"><i class="bx bx-joystick"></i>
                            <span>Mini Games</span></a></li>
                    <li><a href="{{ url('#chart') }}" class="nav-link scrollto"><i class="bx bx-music"></i>
                            <span>Top Chart</span></a></li>
                    <li><a href="{{ url('#events') }}" class="nav-link scrollto"><i class="bx bx-calendar-event"></i>
                            <span>Events</span></a></li>
                    <li><a href="{{ url('#achievements') }}" class="nav-link scrollto"><i class="bx bx-trophy"></i>
                            <span>Achievements</span></a></li>
                    <li><a href="{{ url('#news') }}" class="nav-link scrollto"><i class="bx bx-news"></i>
                            <span>Rapma News</span></a></li>
                    <li><a href="{{ url('#contact') }}" class="nav-link scrollto"><i class="bx bx-envelope"></i>
                            <span>Contact</span></a></li>
                </ul>
            </nav>
            <audio id="demosMenu" style="width: auto; height: 25px;" controls autoplay>
                <source src="{{ $settings->streaming }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
    </header>

    {{-- Main Content --}}
    @yield('page-content')

    {{-- Footer --}}
    <footer id="footer">
        <div class="container">
            <div class="copyright">
                Copyright <strong><span>{{ date('Y') }} <a href="https://rapmafm.com:2222" style="color:black;"
                            target="_blank"> &copy;</a> {{ $settings->owner }}</span></strong>
            </div>
        </div>
    </footer>

    {{-- JavaScript --}}
    <script src="{{ asset('assets/vendor/js/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/glightbox/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/purecounter/purecounter.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/typed.js/typed.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    {{-- Main JavaScript --}}
    <script src="{{ asset('assets/vendor/js/main.js') }}"></script>

    {{-- My Script --}}
    <script src="{{ asset('assets/vendor/js/my-script.js') }}"></script>

    {{-- Live Chat --}}
    <script src="{{ asset('assets/vendor/js/livechat.js') }}"></script>
</body>

</html>

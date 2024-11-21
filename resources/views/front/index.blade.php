@extends('front.templates.index')

@push('styles')
    <style>
        .carousel-item {
            transition: transform 0.5s ease;
        }
    </style>
@endpush

@section('page-content')
    <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
        <div class="hero-container">
            <!-- Nama Website -->
            <h1>{{ $settings->owner }}</h1>
        </div>

        <!-- Slogan -->
        <div class="hero-container">
            <h6><span class="typed" data-typed-items="{{ $settings->slogan }}"></span></h6>
        </div>

        <!-- Social Media -->
        <div class="social-links">
            <div class="d-flex flex-column">
                <div class="profile">

                    <!-- Penyiar -->
                    <center>
                        <div class="my-3" style="color: yellow;">
                            <span>
                                <marquee behavior="scroll" direction="left" scrolldelay="50" truespeed>
                                    @if ($settings->penyiar1 !== '')
                                        <h5>
                                            {{ $settings->program_siar->nama }} || {{ $settings->penyiar1 }}
                                            {{ $settings->penyiar2 !== '' ? 'X ' . $settings->penyiar2 : '' }}
                                        </h5>
                                    @else
                                        <h5>OFF AIR</h5>
                                    @endif
                                </marquee>
                            </span>
                        </div>
                    </center>

                    <!-- Clock -->
                    <center>
                        <div style="color: green;" data-aos="fade-in">
                            <span>
                                <strong>
                                    {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') }}
                                    <br>
                                    (<span id="jam"></span>
                                    {{ \Carbon\Carbon::now('Asia/Jakarta')->format('A') }})
                                </strong>
                            </span>
                        </div>
                    </center>

                    <!-- Sosmed Button -->
                    <div class="social-links mt-3 text-center" data-aos="fade-up">
                        <a href="https://x.com/{{ $settings->twitter }}" target="_blank" title="Twitter">
                            <i class="bx bxl-twitter"></i></a>
                        <a href="https://www.facebook.com/{{ $settings->facebook }}" target="_blank" title="Facebook">
                            <i class="bx bxl-facebook"></i></a>
                        <a href="https://www.instagram.com/{{ $settings->instagram }}" target="_blank" title="Instagram">
                            <i class="bx bxl-instagram"></i></a>
                        <a href="https://www.youtube.com/{{ $settings->youtube }}" target="_blank" title="Youtube">
                            <i class="bx bxl-youtube"></i></a>
                        <a href="https://open.spotify.com/show/{{ $settings->spotify }}" target="_blank" title="Spotify">
                            <i class="bx bxl-spotify"></i></a>
                        <a href="https://wa.me/{{ $settings->whatsapp }}" target="_blank" title="Whatsapp">
                            <i class="bx bxl-whatsapp"></i></a>
                        <a href="{{ $settings->blogger }}" target="_blank" title="Blog">
                            <i class="bx bxl-blogger"></i></a>
                        <a href="https://www.tiktok.com/{{ $settings->tiktok }}" target="_blank" title="TikTok">
                            <i>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="17px" height="17px" preserveAspectRatio="xMidYMid meet" viewBox="-1 1 24 24"
                                    style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                                    <path fill="#fff"
                                        d="M12.525.02c1.31-.02 2.61-.01 3.91-.02c.08 1.53.63 3.09 1.75 4.17c1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97c-.57-.26-1.1-.59-1.62-.93c-.01 2.92.01 5.84-.02 8.75c-.08 1.4-.54 2.79-1.35 3.94c-1.31 1.92-3.58 3.17-5.91 3.21c-1.43.08-2.86-.31-4.08-1.03c-2.02-1.19-3.44-3.37-3.65-5.71c-.02-.5-.03-1-.01-1.49c.18-1.9 1.12-3.72 2.58-4.96c1.66-1.44 3.98-2.13 6.15-1.72c.02 1.48-.04 2.96-.04 4.44c-.99-.32-2.15-.23-3.02.37c-.63.41-1.11 1.04-1.36 1.75c-.21.51-.15 1.07-.14 1.61c.24 1.64 1.82 3.02 3.5 2.87c1.12-.01 2.19-.66 2.77-1.61c.19-.33.4-.67.41-1.06c.1-1.79.06-3.57.07-5.36c.01-4.03-.01-8.05.02-12.07z" />
                                    <rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" />
                                </svg>
                            </i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main id="main">
        <!-- About -->
        <section id="about" class="section-bg">
            <div class="container">
                <div class="section-title">
                    <h2 class="text-center">About</h2>
                    <p style="text-indent: 40px; text-align: justify">{{ $settings->about }}</p>
                    <br>
                    <center>
                        <a href="{{ $settings->link_about }}" target="_blank" class="btn btn-success">Read More..</a>
                    </center>
                </div>
            </div>
        </section>

        <!-- Structure of Organization -->
        <section id="structure" class="portfolio-details-slider">
            <div class="container">
                <div class="section-title">
                    <h2 class="text-center">Structure of Organization</h2>
                </div>
                <div class="row">
                    <div id="carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($structure as $struktur)
                                @if ($struktur->pangkat == 'Pengurus')
                                    <li data-target="#carousel" data-slide-to="{{ $struktur->order - 1 }}"
                                        class="{{ $struktur->order == 1 ? 'active' : '' }}"></li>
                                @endif
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($structure as $struktur)
                                @if ($struktur->pangkat == 'Pengurus')
                                    <div class="carousel-item {{ $struktur->order == 1 ? 'active' : '' }}">
                                        <img src="{{ asset($struktur->path) }}" class="img-fluid"
                                            alt="{{ $struktur->divisi }}" data-aos="fade-up" width="100%">
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Previous -->
                        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>

                        <!-- Next -->
                        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>

                <!-- Crew -->
                <div class="row mt-3">
                    <div class="col section-bottom-button" data-aos="fade-up">
                        @foreach ($structure as $struktur)
                            @if ($struktur->pangkat == 'Crew')
                                <img src="{{ asset($struktur->path) }}" class="img-fluid"
                                    alt="{{ $struktur->divisi }}">
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>
        </section>

        <!-- Program -->
        <section id="program" class="portfolio section-bg">
            <div class="container">
                <div class="section-title">
                    <h2 class="text-center">Program</h2>
                    <h6 class="text-center" style="color: #008C52;">Broadcast & Podcast</h6>
                </div>
                <div class="row" data-aos="fade-up">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="portfolio-flters">
                            <li data-filter="*" class="filter-active" title="All Program">All</li>
                            <li data-filter=".filter-special" title="Special Program">Special</li>
                            <li data-filter=".filter-regular" title="Regular Program">Regular</li>
                            <li data-filter=".filter-podcast" title="Podcast">Podcast</li>
                        </ul>
                    </div>
                </div>

                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="100">
                    @foreach ($program as $siar)
                        <div
                            class="col-lg-4 col-md-6 portfolio-item filter-{{ $siar->program_siar->jenis_program->key }}">
                            <div class="portfolio-wrap">
                                <img src="{{ asset($siar->path) }}" class="img-fluid"
                                    alt="{{ $siar->program_siar->nama }}">
                                <div class="portfolio-links">
                                    <a href="{{ asset($siar->path) }}" data-gallery="portfolioGallery"
                                        class="portfolio-lightbox"><i class="bx bx-zoom-in" title="Zoom In"></i></a>
                                    <a href="{{ $siar->link }}" target="_blank"><i class="bx bxl-spotify"
                                            title="Open Spotify"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Top Charts -->
        <section id="chart" class="section-bg">
            <div class="container">
                <div class="section-title">
                    <h2 class="text-center">Rapma Top 15</h2>
                </div>
                <div class="row" data-aos="fade-in">
                    @foreach ($topcharts as $topchart)
                        <div class="col-lg-6 d-flex align-items-stretch mb-4">
                            <div class="row">
                                <h2 class="text-center" style="color: #008C52;">Top 15 Versi {{ $topchart->versi }}</h2>
                                <iframe src="{{ $topchart->link }}" width="100%" height="500px"></iframe>
                            </div>
                        </div>
                    @endforeach
                </div>
        </section>

        <!-- Events -->
        <section id="events">
            <div class="container">
                <div class="row g-4 g-md-6">
                    <div class="section-title">
                        <h2 class="text-center">Events</h2>
                    </div>
                    @foreach ($events as $event)
                        <div class="col-6 col-md-6" data-aos="fade-up">
                            <div class="card-body">
                                <center>
                                    <h2 class="card-title"><b>{{ $event->nama_event }}</b></h2>
                                </center>
                                <center class="eventrapma">
                                    <img class="card-img-top" src="{{ asset($event->path) }}" style="width:100%">
                                </center>
                                <div class="card-body">
                                    <center>
                                        <a href="{{ $event->link }}" target="_blank" class="btn btn-success">See
                                            Event</a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Achievements -->
        <section id="achievements" class="section-bg">
            <div class="container">
                <div class="row g-2 g-lg-4">
                    <div class="section-title">
                        <h2 class="text-center">Achievements</h2>
                    </div>
                    @foreach ($achievements as $achievement)
                        <div class="col-12 col-lg-4" data-aos="fade-up">
                            <div class="card">
                                <center>
                                    <h5 class="card-title p-2">{{ $achievement->judul }} <br>({{ $achievement->tahun }})
                                    </h5>
                                    <div class="achievementrapma">
                                        <img class="card-img-top px-3" src="{{ asset($achievement->path) }}">
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ $achievement->link }}" target="_blank" class="btn btn-success">See
                                            Details</a>
                                    </div>
                                </center>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Rapma News -->
        <section id="news">
            <div class="container">
                <div class="row g-2 g-lg-4">
                    <div class="section-title">
                        <h2 class="text-center">Rapma News</h2>
                    </div>
                    @foreach ($rapmanews as $news)
                        <div class="col-12 col-lg-4" data-aos="fade-up">
                            <div class="card" style="min-height: 700px;">
                                <div class="rapmanews">
                                    <img class="card-img-top img-fluid p-2 mh-300" src="{{ asset($news->path) }}">
                                </div>
                                <small style="color:slategray;" class="text-center">
                                    {{ \Carbon\Carbon::parse($news->tanggal)->locale('id')->translatedFormat('d F Y (H:i)') }}
                                </small>
                                <div class="card-body text-center">
                                    <a href="{{ $news->link }}" target="_blank">
                                        <h5 class="card-title" style="color: black;">{{ $news->judul }}</h5>
                                    </a>
                                    <p class="card-text text-justify pt-1">{{ $news->deskripsi }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Contact -->
        <section id="contact" class="contact">
            <div class="container">
                <div class="section-title">
                    <h2 class="text-center">Contact</h2>
                </div>
                <div class="row" data-aos="fade-in">
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="info">
                            <div class="email">
                                <i class="bi bi-envelope" title="Email"></i>
                                <h4>Email</h4>
                                <p>
                                    {{ $settings->gmail }}
                                    <br>
                                    {{ $settings->ymail }} (Music Director)
                                </p>
                            </div>
                            <div class="phone">
                                <i class="bi bi-phone" title="Whatsapp"></i>
                                <h4>Whatsapp</h4>
                                <p>
                                    <a href="https://wa.me/+62{{ $settings->no_medpart }}" target="_blank"
                                        style="color: #008C52;">{{ $settings->nama_medpart }} :
                                        0{{ $settings->no_medpart }} (MedPart)</a><br>
                                    <a href="https://wa.me/+62{{ $settings->no_mtalent }}" target="_blank"
                                        style="color: #008C52;">{{ $settings->nama_mtalent }} :
                                        0{{ $settings->no_mtalent }} (MC/M-Talent)</a><br>
                                </p>
                            </div>
                            <div class="address">
                                <i class="bi bi-geo-alt" title="Location"></i>
                                <h4>Location</h4>
                                <p class="text-justify">{{ $settings->alamat }}</p>
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.1722825033103!2d110.76873700406814!3d-7.556185825852349!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a145b44ab2e7b%3A0x907e13e28374d39b!2sRapma+FM!5e0!3m2!1sid!2sid!4v1547644067180"
                                    width="100%" height="100%"></iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Forms -->
                    <div class="col-lg-6 mt-5 mt-lg-0 d-flex align-items-stretch">
                        <form action="{{ route('message.send') }}" method="POST" class="php-email-form"
                            id="form-pesan" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nama">Your Name</label>
                                    <input type="text" name="nama" class="form-control rounded-3" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control rounded-3" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" class="form-control rounded-3" name="subject" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control rounded-3" name="message" rows="10" required></textarea>
                            </div>
                            <div class="my-3">
                                <div class="loading">Loading</div>
                            </div>
                            <div class="text-center"><button type="submit" title="Send Message">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        $('#form-pesan').on('submit', function(e) {
            e.preventDefault();

            let data = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: () => {
                    console.log("Sending message...");
                    clearErrorMessage();
                    Swal.fire({
                        title: 'Mengirim...',
                        html: '<div class="spinner-border text-primary" role="status"></div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                },
                success: (res) => {
                    console.log(res);
                    if (res.status) {
                        Swal.close();
                        $('#form-pesan')[0].reset();
                        clearErrorMessage();
                        Swal.fire({
                            title: 'Berhasil!',
                            text: res.message || 'Pesan Anda telah dikirim.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.close();
                        Swal.fire({
                            title: 'Gagal!',
                            text: res.message || 'Terjadi kesalahan.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });
    </script>
@endpush

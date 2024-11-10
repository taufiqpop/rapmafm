@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

@section('contents')
    <div class="card-body">
        <div class="media">
            <img src="assets/images/logo/afel_hitam.png" class="avatar-sm mb-4" style="width: 300px; height: auto;">
            <div class="media-body ml-4">
                <p class="text-dark" style="font-size: 2rem;">Assessment For Economics Learning</p>
                <div class="card-text">
                    <p class="text-dark text-justify" style="font-size: 1.1rem;">
                        Penilaian seringkali dianggap sebagai rutinitas aktifitas pada akhir pembelajaran. Pembelajaran dan
                        penilaian merupakan aktifitas bersamaan, sebagaimana yang disampaikan DiRanna (2008: 7) <i>"when you
                            teach, you begin with assessment"</i>.
                    </p>
                    <p class="text-dark text-justify" style="font-size: 1.1rem;">
                        Saat ini inovasi penggunaan teknologi dalam penilaian berkembang dengan pesat, ditandai dengan
                        banyaknya aplikasi/website yang memfasilitasi media penilaian secara online. Penggunaan aplikasi
                        tersebut juga perlu didukung dengan pemahaman terminologi penilaian yang baik dari para guru sebagai
                        desainer yang merancang penilaian pembelajaran. Dengan demikian, penilaian pembelajaran yang
                        dilakukan dapat menghasilkan informasi pembelajaran, yang dapat digunakan guru untuk mengambil
                        keputusan terkait keberhasilan guru dalam mengajar dan keberhasilan peserta didik dalam belajar.
                    </p>
                </div>
            </div>
        </div>
        <div>
            <p class="text-dark text-justify" style="font-size: 1.1rem;">
                Penetapan tujuan pembelajaran, indikator capaian, kisi-kisi, rubrik penilaian merupakan seperangkat
                aktifitas yang mutlak dilakukan sebelum melaksanakan penilaian. Namun, mayoritas guru menganggap aktifitas
                tersebut sebagai kegiatan prosedural serta membutuhkan konsentrasi waktu dan pikiran, sehingga banyak guru
                yang tidak merancang perangkat penilaian dan mengambil jalan pintas dengan menggunakan template perangkat
                penilaian yang dapat diunduh secara bebas.
            </p>
            <p class="text-dark text-justify" style="font-size: 1.1rem;">
                <i>Assessment for Economics Learning</i> dengan bantuan Platform Sistem Perangkat Penilaian, atau disebut
                dengan AFEL-SPP merupakan penilaian pembelajaran ekonomi dengan berisikan enam sintaks, yang harus
                diimplementasikan secara berurutan dan lengkap.
            </p>
            <img src="assets/images/Alur-AFEL.png">

            <p class="text-dark text-justify" style="font-size: 1.1rem;">
                Tujuan AFEL-SPP adalah:
                <br>1. Membantu guru ekonomi dalam melakukan monitoring kemajuan belajar peserta didik <i>(monitoring
                    student progress)</i>.
                <br>2. Memberikan umpan balik <i>(provide feedback)</i>.
                <br>3. Memperbaiki metode pengajaran guru <i>(adjust teaching method)</i>.
            </p>
            <p class="text-dark text-justify" style="font-size: 1.1rem;">
                AFEL-SPP menfasilitasi penggunanya untuk merancang dan mengadministrasikan perangkat penilaian pembelajaran
                khususnya kisi-kisi dan rubrik penilaian dalam SPP, yang bisa diakses dan diunduh sesuai dengan kelas yang
                diselenggarakan.
            </p>
            <p class="text-dark text-justify" style="font-size: 1.1rem;">
                AFEL-SPP dapat digunakan untuk jenis kurikulum apapun, karena AFEL-SPP menggunakan nomenklatur universal dan
                tidak terikat dengan nomenklatur kurikulum yang digunakan.
            </p>
            <p class="text-dark text-justify" style="font-size: 1.1rem;">
                AFEL-SPP merupakan <i>worksheet</i> internal guru dalam menyelenggarakan dan mengadministrasikan penilaian
                pembelajaran ekonomi.
            </p>
            <p class="text-dark text-justify" style="font-size: 1.1rem;">
                Untuk petunjuk teknis penggunaan AFEL-SPP ini, dapat mengunduh link berikut ini :
            </p>
            <center>
                <a href="https://afel.online/storage/uploads/beranda/PetunjukTeknisAFEL-SPP.pdf" class="btn-lg btn-primary"
                    target="_blank"><b><i class="bx bx-book"></i> Link Book</b></a>
                <a href="#" class="btn-lg btn-info" onclick="showSwalVideo()"><b><i class="bx bx-video"></i> Link
                        Video</b></a>
            </center>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function showSwalBook() {
            Swal.fire({
                icon: 'info',
                title: 'E-Book Belum Tersedia!',
                text: 'Silakan Cek Kembali Nanti',
                confirmButtonText: 'OK'
            });
        }

        function showSwalVideo() {
            Swal.fire({
                icon: 'info',
                title: 'Video Belum Tersedia!',
                text: 'Silakan Cek Kembali Nanti',
                confirmButtonText: 'OK'
            });
        }
    </script>
@endpush

<!DOCTYPE html>
<html lang="en">
@include('layout.head')
<style>
    body {
        padding-top: 50px;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
        <div class="container">

            <a class="navbar-brand fw-bold brand-color d-flex align-items-center" href="#">
                <img src="{{asset('AdminLTE/dist/assets/img/himasif 24-25.png')}}" alt="Logo" height="40" class="me-2">
                <span class="brand-text" style="color: #003580;">SI HIMASIF</span>
            </a>


            <div class="collapse navbar-collapse justify-content-end" id="navMenu">

                <ul class="navbar-nav align-items-center gap-3">

                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#profil">Profil</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#filosofi">Filosofi</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#agenda">Agenda</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-blue-custom btn-sm px-3">
                            Masuk
                        </a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>

    <section id="beranda" class="py-5 bg-white">
        <div class="container">

            <div class="row align-items-center">
                <div class="col-lg-6">

                    <h1 class="fw-bold mb-3" style="color:#003580;">
                        Bangun Potensimu Bersama <br>
                        <span style="color:#003580;">HIMASIF</span>
                    </h1>

                    <p class="text-muted mb-4">
                        Jadilah bagian dari perjalanan pengembangan diri yang seru,
                        penuh inovasi, dan penuh kebersamaan. HIMASIF hadir sebagai
                        wadah untuk belajar, berkarya, dan berkembang.
                    </p>

                    <a href="{{ route('daftar') }}" class="btn btn-blue-custom px-4 py-2 rounded-3">
                        Daftar
                    </a>

                </div>

                <div class="col-lg-6 text-end">

                    <img src="{{asset('img/himasif.jpg')}}"
                        class="img-fluid rounded-4"
                        alt="Hero Image">

                </div>

            </div>

        </div>
    </section>

    <section id="profil" class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <h4 style="color: #003580;" class="fw-semibold">Profil</h4>
                <p style="text-align: justify;">HIMASIF (Himpunan Mahasiswa Sistem Informasi) merupakan organisasi kemahasiswaan yang menaungi mahasiswa Program Studi Sistem Informasi di Fakultas Teknik, Universitas Bengkulu. HIMASIF diresmikan pada 24 April 2018 dan tetap aktif hingga sekarang tanpa batas waktu kepengurusan yang ditentukan. HIMASIF berkedudukan di Program Studi Sistem Informasi, Fakultas Teknik, Universitas Bengkulu.
                </p>
                <br>
                <p style="text-align: justify;">Sebagai organisasi pengembangan mahasiswa, HIMASIF berfungsi sebagai wadah untuk menyalurkan aspirasi seluruh anggota Sistem Informasi Universitas Bengkulu, khususnya dalam pengembangan pengetahuan bisnis yang berbasis teknologi informasi (IT Business). HIMASIF juga menjadi ruang kolaborasi, peningkatan kompetensi akademik maupun non-akademik, serta pembentukan karakter dan profesionalisme mahasiswa Sistem Informasi.</p>
                <br>
                <p style="text-align: justify;">Dalam menjalankan setiap program kerjanya, HIMASIF berpegang pada prinsip profesional, kreatif, dan independen, sehingga setiap kegiatan yang dilaksanakan berorientasi pada kemanfaatan dan kontribusi nyata. Adapun kekuasaan tertinggi berada pada anggota HIMASIF Fakultas Teknik Universitas Bengkulu, sebagai wujud demokrasi dan partisipasi aktif seluruh anggota dalam menentukan arah gerak organisasi.</p>
            </div>
            <div class="row align-items-center">
                <h4 style="color: #003580;" class="fw-semibold">Visi</h4>
                <p>Menjadikan HIMASIF yang berwawasan nasional pada tahun 2025 dan internasional pada tahun 2030.</p>
            </div>
            <div class="row align-items-center">
                <h4 style="color: #003580;" class="fw-semibold">Misi</h4>
                <ol class="ps-4">
                    <li>Mewujudkan HIMASIF yang bermasyarakat dan profesional</li>
                    <li>Menjadikan HIMASIF sebagai wadah aspirasi bagi anggota Sistem Informasi</li>
                    <li>Meningkatkan kualitas HIMASIF di bidang IPTEK</li>
                    <li>Menjalin hubungan kerja sama dengan pihak internal maupun eksternal</li>
                    <li>Mengadakan kegiatan inovatif dan kreatif untuk pengabdian masyarakat</li>
                </ol>
            </div>
        </div>

    </section>
    <section id="filosofi" class="py-5 bg-white">
        <div class="container">
            <h4 style="color: #003580;" class="fw-semibold">Filosopi Logo</h4>
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <ol class="ps-3">
                        <li style="text-align: justify;">Kombinasi warna biru dan oranye, melambangkan warna Fakultas Teknik Universitas Bengkulu</li>
                        <li style="text-align: justify;">Logo membentuk heksagonal (segi enam) yang merepresentasikan bahwa Fakultas Teknik Universitas Bengkulu memiliki 6 program studi dimana program studi Sistem Informasi ada di dalamnya.</li>
                        <li style="text-align: justify;">Bintang segi 6 menggunakan warna kuning yang melambangkan prestasi</li>
                        <li style="text-align: justify;">Desain Monogram dari huruf S dan I (Sistem Informasi). Menggunakan warna desar merah yang melambangkan kekuatan dan keberanian.</li>
                        <li style="text-align: justify;">Tipe huruf menggunakan Sans Serif dengan warna dasar putih. Huruf seperti melambangkan ketegasan, bersifat fungsional modern. Warna putih melambangkan kesederhanaan.</li>
                    </ol>
                </div>

                <div class="col-lg-3 text-end">
                    <img src="{{asset('img/logo.png')}}"
                        class="img-fluid rounded-4"
                        alt="Hero Image">

                </div>
            </div>
        </div>


        <div class="container">
            <h4 style="color: #003580;" class="fw-semibold">Pakaian Dinas Harian (PDH)</h4>
            <div class="row align-items-center">

                <div class="col-lg-6 text-start">
                    <img src="{{asset('img/baju-himasif.jpg')}}"
                        class="img-fluid rounded-4"
                        alt="Hero Image">

                </div>
                <div class="col-lg-6">
                    <h6>Jadi bagian dari HIMASIF dan gunakan PDH-mu setiap hari Kamis!</h6>
                    <p style="text-align: justify;">Pakaian Dinas Harian (PDH) HIMASIF menampilkan identitas profesional dan kebanggaan mahasiswa Sistem Informasi. Warna utama mencerminkan karakter fakultas, dilengkapi logo HIMASIF dan elemen identitas organisasi yang terstruktur. PDH ini digunakan untuk kegiatan resmi seperti rapat, agenda kampus, dan representasi eksternal.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="agenda" class="py-5 bg-light">

        <div class="container">

            <h4 class="fw-semibold" style="color:#003580;">
                Agenda
            </h4>

            <div class="row g-4">

                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">

                        <img src="{{asset('img/amerta.png')}}"
                            class="card-img-top rounded-top-4"
                            style="height:180px; object-fit:cover;">

                        <div class="card-body">
                            <h6 class="fw-bold">AMERTA</h6>
                            <p class="text-muted small mb-0" style="text-align:justify;">
                                Amerta / Kemah Bakti Sosial HIMASIF adalah kegiatan tahunan yang mengajak mahasiswa terjun langsung ke masyarakat melalui aksi bakti sosial, edukasi, dan kegiatan kebersamaan untuk membangun solidaritas, kepedulian, dan kekompakan antar anggota.
                            </p>
                        </div>

                    </div>
                </div>


                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">

                        <img src="{{ asset('img/agatis2025.png') }}"
                            class="card-img-top rounded-top-4"
                            style="height:180px; object-fit:cover;">

                        <div class="card-body">
                            <h6 class="fw-bold">AGATIS</h6>
                            <p class="text-muted small mb-0" style="text-align:justify;">
                                AGATIS (Anniversary and Gathering of Information System) adalah kegiatan tahunan HIMASIF yang diselenggarakan untuk memperingati hari jadi HIMASIF. Kegiatan ini turut menghadirkan berbagai lomba tingkat nasional di bidang teknologi sebagai wadah kompetisi dan inovasi bagi mahasiswa dan siswa dari seluruh Indonesia.
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">

                        <img src="{{ asset('img/cois.png') }}"
                            class="card-img-top rounded-top-4"
                            style="height:180px; object-fit:cover;">

                        <div class="card-body">
                            <h6 class="fw-bold">COIS</h6>
                            <p class="text-muted small mb-0" style="text-align:justify;">
                                COIS (Competition of Information System) adalah kompetisi internal antar angkatan mahasiswa Sistem Informasi pada berbagai cabang lomba. Kegiatan ini menjadi ajang untuk menunjukkan kemampuan, meningkatkan sportivitas, serta mempererat kekompakan dan semangat persaingan sehat di lingkungan program studi Sistem Informasi.
                            </p>
                        </div>

                    </div>
                </div>

            </div>

            <div class="row g-4 pt-5">

                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">

                        <img src="{{asset('img/olahraga.png')}}"
                            class="card-img-top rounded-top-4"
                            style="height:180px; object-fit:cover;">

                        <div class="card-body">
                            <h6 class="fw-bold">OLAHRAGA</h6>
                            <p class="text-muted small mb-0" style="text-align:justify;">
                                Amerta / Kemah Bakti Sosial HIMASIF adalah kegiatan tahunan yang mengajak mahasiswa terjun langsung ke masyarakat melalui aksi bakti sosial, edukasi, dan kegiatan kebersamaan untuk membangun solidaritas, kepedulian, dan kekompakan antar anggota.
                            </p>
                        </div>

                    </div>
                </div>


                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">

                        <img src="{{ asset('img/takjil.png') }}"
                            class="card-img-top rounded-top-4"
                            style="height:180px; object-fit:cover;">

                        <div class="card-body">
                            <h6 class="fw-bold">PEMBAGIAN TAKJIL</h6>
                            <p class="text-muted small mb-0" style="text-align:justify;">
                                Pembagian Takjil di bulan Ramadhan adalah kegiatan sosial HIMASIF yang dilakukan dengan membagikan makanan berbuka puasa kepada masyarakat. Kegiatan ini bertujuan menumbuhkan rasa kepedulian, berbagi kebaikan, serta mempererat silaturahmi antaranggota HIMASIF dan lingkungan sekitar selama bulan suci Ramadhan.
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">

                        <img src="{{ asset('img/gotongroyong.png') }}"
                            class="card-img-top rounded-top-4"
                            style="height:180px; object-fit:cover;">

                        <div class="card-body">
                            <h6 class="fw-bold">GOSIF</h6>
                            <p class="text-muted small mb-0" style="text-align:justify;">
                                GOSIF (Gotong Royong Himasif) adalah kegiatan kerja bakti yang melibatkan seluruh anggota HIMASIF untuk menjaga kebersihan dan kerapian lingkungan sekitar sekretariat. Anggota diajak menumbuhkan rasa peduli, solidaritas, serta kebersamaan dengan bekerja sama secara langsung dalam menciptakan lingkungan yang bersih dan nyaman.
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </section>

    <section id="kontak" class="py-5 text-center bg-light">
        <div class="container">
            <h3 class="fw-bold mb-3" style="color:#003580;">Hubungi Kami!</h3>
            <p class="text-muted mb-4">
                Punya pertanyaan? Kritik & saran? Atau cuma mau kenalan?
                Tim HIMASIF selalu senang mendengar kabar dari kamu!
            </p>

            <a href="#" class="btn btn-blue-custom btn-uniform">
                Kirim Pesan
            </a>
        </div>
    </section>


    <footer class="text-white" style="background:#0d3b7a;">
        <div class="container py-5">

            <!-- BARIS ATAS -->
            <div class="row text-center mb-5 align-items-center">

                <div class="col-md-4 d-flex justify-content-center">
                    <a class="navbar-brand fw-bold brand-color d-flex align-items-center" href="#">
                        <img src="{{asset('AdminLTE/dist/assets/img/himasif 24-25.png')}}" alt="Logo" height="40" class="me-2">
                        <h5 class="fw-bold mb-0">SI HIMASIF</h5>
                    </a>
                </div>

                <div class="col-md-4">
                    <small>© 2025 HIMASIF. All rights reserved.</small>
                </div>

                <div class="col-md-4 d-flex justify-content-center gap-3">
                    <i class="bi bi-instagram fs-5"></i>
                    <i class="bi bi-tiktok fs-5"></i>
                    <i class="bi bi-youtube fs-5"></i>
                </div>

            </div>


            <!-- BARIS BAWAH -->
            <div class="row text-center gy-4">

                <div class="col-md-4">
                    <i class="bi bi-globe fs-2 mb-3"></i>
                    <h6 class="fw-semibold">Website</h6>
                    <small>www.himasif.ac.id</small>
                </div>

                <div class="col-md-4 border-start border-end">
                    <i class="bi bi-geo-alt fs-2 mb-3"></i>
                    <h6 class="fw-semibold">Lokasi</h6>
                    <small>
                        Sekretariat Gedung Laboratorium Terpadu<br>
                        Fakultas Teknik Universitas Bengkulu
                    </small>
                </div>

                <div class="col-md-4">
                    <i class="bi bi-envelope fs-2 mb-3"></i>
                    <h6 class="fw-semibold">Email</h6>
                    <small>sist.informasi@unib.ac.id</small>
                </div>

            </div>

        </div>
    </footer>




</body>

</html>
<!DOCTYPE html>
<html lang="id">
@include('layout.head')
<style>
    body {
        padding-top: 50px;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">

            <a class="navbar-brand fw-bold brand-color d-flex align-items-center" href="#">
                <img src="{{asset('img/logo.png')}}" alt="Logo" height="40" class="me-2">
                <span class="brand-text colorblue">SIMAKSIF</span>
            </a>

            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>


            <div class="collapse navbar-collapse justify-content-end" id="navMenu">

                <ul class="navbar-nav align-items-center gap-3">

                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#keunggulan">Keunggulan</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#panduan">Panduan</a>
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

                    <h1 class="fw-bold mb-3 colorblue">
                        SIMAKSIF
                    </h1>
                    <h4 class="fw-bold mb-3 colorblue">
                        Sistem Informasi Manajemen Administrasi dan Keuangan Organisasi HIMASIF<br>
                    </h4>

                    <p class="text-muted mb-4">
                        Wujudkan administrasi yang tertata dan keuangan yang transparan
                        melalui sistem terintegrasi yang mendukung kinerja organisasi secara efektif.
                    </p>

                    <a href="{{ route('daftar') }}" class="btn btn-blue-custom px-4 py-2 rounded-3">
                        Daftar
                    </a>

                </div>

                <div class="col-lg-6 text-end">

                    <img src="{{asset('img/admin-rm.png')}}"
                        class="img-fluid rounded-4"
                        alt="Thumbnail Image"
                        style="max-width: 400px;">

                </div>

            </div>

        </div>
    </section>

    <section id="tentang" class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <h4 class="fw-semibold colorblue">TENTANG SIMAKSIF</h4>
                <p style="text-align: justify;">Pengelolaan administrasi dan keuangan organisasi di HIMASIF sebelumnya masih dilakukan secara terpisah dan belum terintegrasi dalam satu sistem. Arsip surat masuk, surat keluar, dokumen kegiatan, sertifikat, serta informasi anggota belum terdokumentasi secara terpusat. Penyimpanan dilakukan pada media yang berbeda sehingga menyulitkan proses pencarian dan referensi kegiatan pada periode berikutnya.
                </p>
                <br>
                <p style="text-align: justify;">Di sisi keuangan, informasi mengenai kas masuk dan kas keluar belum dapat diakses secara transparan oleh anggota sehingga monitoring saldo organisasi belum berjalan secara optimal.</p>
                <br>
                <p style="text-align: justify;">SIMAKSIF menyediakan dua fitur utama, yaitu administrasi dan keuangan. Pada pengelolaan arsip administrasi terdiri dari fitur surat masuk, surat keluar, sertifikat, dokumen kegiatan, serta keanggotaan. Adapun pada keuangan, terdiri dari fiturs kas masuk, kas keluar, serta laporan keuangan dengan mekanisme akses berbasis peran. Sistem ini dirancang untuk digunakan oleh Sekretaris Umum, Bendahara Umum, dan Anggota sesuai dengan hak akses masing-masing. </p>
            </div>
            <div class="row align-items-center">
                <h4 class="fw-semibold colorblue">TUJUAN PENGEMBANGAN</h4>
                <p>SIMAKSIF dikembangkan sebagai solusi terintegrasi untuk mendukung manajemen administrasi dan keuangan organisasi secara lebih tertata, terdokumentasi, dan transparan. Sistem ini dirancang untuk:</p>
                <ol class="ps-4">
                    <li>Mengintegrasikan arsip surat dan dokumen kegiatan dalam satu platform terpusat</li>
                    <li>Mengelola kas masuk dan kas keluar secara sistematis</li>
                    <li>Meningkatkan transparansi informasi keuangan kepada anggota</li>
                </ol>
            </div>
        </div>

    </section>

    <section id="keunggulan" class="py-5 bg-white">
        <div class="container">
            <h4 class="fw-semibold colorblue">KEUNGGULAN</h4>
            <div class="row align-items-center">
                <div class="col-lg-3 text-start">
                    <img src="{{asset('img/logo.png')}}"
                        class="img-fluid rounded-4"
                        alt="Hero Image">

                </div>
                <div class="col-lg-9">
                    <h6 class="fw-medium colorblue">1. Arsip Terpusat dan Terstruktur</h6>
                    <p style="text-align: justify;">Seluruh dokumen organisasi seperti surat masuk, surat keluar, sertifikat, dan dokumen kegiatan tersimpan dalam satu sistem terintegrasi sehingga memudahkan pencarian dan referensi pada periode berikutnya.</p>
                    <h6 class="fw-medium colorblue">2. Penomoran Surat Terkontrol</h6>
                    <p style="text-align: justify;">Sistem membantu mengurangi risiko duplikasi nomor surat dengan mekanisme pencatatan yang lebih tertata dibandingkan metode manual sebelumnya.</p>
                    <h6 class="fw-medium colorblue">3. Transparansi Keuangan Organisasi</h6>
                    <p style="text-align: justify;">Informasi kas masuk dan kas keluar dapat dimonitor secara sistematis sehingga meningkatkan keterbukaan dan akuntabilitas pengelolaan dana organisasi.</p>
                    <h6 class="fw-medium colorblue">4. Akses Berbasis Peran</h6>
                    <p style="text-align: justify;">Setiap pengguna memiliki hak akses sesuai tanggung jawabnya, sehingga pengelolaan administrasi dan keuangan tetap terkontrol namun tetap dapat dipantau oleh anggota.</p>
                    <h6 class="fw-medium colorblue">5. Dokumentasi Berkelanjutan</h6>
                    <p style="text-align: justify;">Data tersimpan secara digital dan terdokumentasi dengan baik sehingga dapat digunakan sebagai referensi untuk kepengurusan selanjutnya.</p>
                </div>

            </div>
        </div>
    </section>

    <section id="panduan" class="py-5 bg-light">
        <div class="container">

            <div class="row align-items-center">
                <div class="col-lg-9">

                    <h1 class="fw-bold mb-3 colorblue">
                        PANDUAN
                    </h1>

                    <p class="text-muted mb-4">
                        SIMAKSIF dilengkapi dengan modul panduan penggunaan yang dirancang untuk membantu
                        setiap pengguna memahami alur sistem sesuai dengan perannya.
                        Panduan ini memastikan proses administrasi dan keuangan organisasi
                        dapat berjalan secara efektif dan terstruktur.
                    </p>

                    <a href="{{ asset('pdf/modul.pdf') }}" target="_blank" class="btn btn-blue-custom btn-uniform">
                        Lihat Modul
                    </a>

                </div>

                <div class="col-lg-3 text-end">

                    <img src="{{asset('img/himasif.jpg')}}"
                        class="img-fluid rounded-4"
                        alt="Thumbnail Image">

                </div>

            </div>

        </div>



    </section>

    <section id="kontak" class="py-5 text-center bg-white">
        <div class="container">
            <h3 class="fw-bold mb-3 colorblue">HUBUNGI KAMI!</h3>
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


            <div class="row text-center mb-5 align-items-center">

                <div class="col-md-4 d-flex justify-content-center">
                    <a class="navbar-brand fw-bold brand-color d-flex align-items-center" href="#">
                        <img src="{{asset(path: 'img/logo.png')}}" alt="Logo" height="40" class="me-2">
                        <h5 class="fw-bold mb-0">SIMAKSIF</h5>
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
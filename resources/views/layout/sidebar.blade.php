<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sidebar</title>
</head>

<body>
  <!--begin::Sidebar-->
  <aside class="app-sidebar shadow sidebar-light">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
      <!--begin::Brand Link-->
      <a href="#" class="brand-link">
        <!--begin::Brand Image-->
        <img
          src="{{asset('img/logo.png')}}"
          alt="Logo"
          class="brand-image" />
        <!--end::Brand Image-->
        <!--begin::Brand Text-->
        <span class="brand-text">SIMAKSIF</span>
        <!--end::Brand Text-->
      </a>
      <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul
          class="nav sidebar-menu flex-column"
          data-lte-toggle="treeview"
          role="navigation"
          aria-label="Main navigation"
          data-accordion="false"
          id="navigation">
          <!-- Sekretaris Umum -->
          @if (Str::length(Auth::guard('user')->user()) > 0)
          @if (Auth::guard('user')->user()->level=="Sekretaris Umum")
          <li class="nav-item">
            <a href="{{ route('beranda-sekum') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-house sb-icon"></i>
              <p class="sb-text">Beranda</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa-solid fa-envelope sb-icon"></i>
              <p class="sb-text">
                Surat-menyurat
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('surat-masuk.index')}}" class="nav-link">
                  <i class="nav-icon bi bi-circle sb-icon"></i>
                  <p class="sb-text">Surat Masuk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('surat-keluar.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle sb-icon"></i>
                  <p class="sb-text">Surat Keluar</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('sertifikat.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-file sb-icon"></i>
              <p class="sb-text">Sertifikat</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('dokumen-kegiatan.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-file-fragment sb-icon"></i>
              <p class="sb-text">Dokumen Kegiatan</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('member.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-users sb-icon"></i>
              <p class="sb-text">Anggota</p>
            </a>
          </li>
          @endif
          @endif

          <!-- Bendahara Umum -->
          @if (Str::length(Auth::guard('user')->user()) > 0)
          @if (Auth::guard('user')->user()->level=="Bendahara Umum")
          <li class="nav-item">
            <a href="{{ route('beranda-bendum') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-house sb-icon"></i>
              <p class="sb-text">Beranda</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa-solid fa-wallet sb-icon"></i>
              <p class="sb-text">
                Kas Masuk
                <i class="nav-arrow bi bi-chevron-right sb-icon"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('iuran.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle sb-icon"></i>
                  <p class="sb-text">Iuran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('pemasukan.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle sb-icon"></i>
                  <p class="sb-text">Pemasukan</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('kas-keluar.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-credit-card sb-icon"></i>
              <p class="sb-text">Kas Keluar</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('laporan-kas.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-folder sb-icon"></i>
              <p class="sb-text">Laporan Kas</p>
            </a>
          </li>
          @endif
          @endif

          <!-- Anggota -->
          @if (Str::length(Auth::guard('anggota')->user()) > 0)
          @if (Auth::guard('anggota')->user()->level=="Anggota")

          <li class="nav-item">
            <a href="{{ route('beranda-anggota') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-house sb-icon"></i>
              <p class="sb-text">Beranda</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa-solid fa-folder sb-icon"></i>
              <p class="sb-text">
                Administrasi Umum
                <i class="nav-arrow bi bi-chevron-right sb-icon"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">

              
              <li class="nav-item">
                <a href="{{ route('sertifikat-anggota.index') }}" class="nav-link">
                  <i class="nav-icon fa-solid fa-file sb-icon"></i>
                  <p class="sb-text">Sertifikat</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('dokumen-kegiatan-anggota.index') }}" class="nav-link">
                  <i class="nav-icon fa-solid fa-file-fragment sb-icon"></i>
                  <p class="sb-text">Dokumen Kegiatan</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('member-anggota.index') }}" class="nav-link">
                  <i class="nav-icon fa-solid fa-users sb-icon"></i>
                  <p class="sb-text">Anggota</p>
                </a>
              </li>

            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa-solid fa-wallet sb-icon"></i>
              <p class="sb-text">
                Keuangan
                <i class="nav-arrow bi bi-chevron-right sb-icon"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">

              {{-- Kas Masuk --}}
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fa-solid fa-money-bill sb-icon"></i>
                  <p class="sb-text">
                    Kas Masuk
                    <i class="nav-arrow bi bi-chevron-right sb-icon"></i>
                  </p>
                </a>

                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('iuran-anggota.index') }}" class="nav-link">
                      <i class="nav-icon bi bi-circle sb-icon"></i>
                      <p class="sb-text">Iuran</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{ route('pemasukan-anggota.index') }}" class="nav-link">
                      <i class="nav-icon bi bi-circle sb-icon"></i>
                      <p class="sb-text">Pemasukan</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="{{ route('kas-keluar-anggota.index') }}" class="nav-link">
                  <i class="nav-icon fa-solid fa-credit-card sb-icon"></i>
                  <p class="sb-text">Kas Keluar</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('laporan-kas-anggota.index') }}" class="nav-link">
                  <i class="nav-icon fa-solid fa-folder sb-icon"></i>
                  <p class="sb-text">Laporan Kas</p>
                </a>
              </li>

            </ul>
          </li>

          @endif
          @endif
        </ul>
        <!--end::Sidebar Menu-->
      </nav>
    </div>
    <!--end::Sidebar Wrapper-->
  </aside>
  <!--end::Sidebar-->
</body>

</html>
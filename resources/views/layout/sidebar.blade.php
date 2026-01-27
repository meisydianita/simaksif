<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <!--begin::Sidebar-->
  <aside class="app-sidebar shadow" style="background-color: #ffffff;" data-bs-theme="light">
    <style>
      /* Inline style untuk quick fix */
      .app-sidebar[style*="background-color: #ffffff"] .nav-link:hover {
        background-color: rgba(0, 53, 128, 0.1) !important;
        border-left: 3px solid #003580 !important;
      }

      .app-sidebar[style*="background-color: #ffffff"] .nav-link.active {
        background-color: rgba(0, 53, 128, 0.15) !important;
      }

      /*# sourceMappingURL=adminlte.css.map */
    </style>
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
      <!--begin::Brand Link-->
      <a href="#l" class="brand-link">
        <!--begin::Brand Image-->
        <img
          src="{{asset('AdminLTE/dist/assets/img/himasif 24-25.png')}}"
          alt="AdminLTE Logo"
          class="brand-image" />
        <!--end::Brand Image-->
        <!--begin::Brand Text-->
        <span class="brand-text" style="color: #003580;">SI HIMASIF</span>
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
              <i class="nav-icon fa-solid fa-house" style="color: #003580;"></i>
              <p style="color: #003580;">Beranda</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa-solid fa-envelope" style="color: #003580;"></i>
              <p style="color: #003580;">
                Surat-menyurat
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('surat-masuk.index')}}" class="nav-link">
                  <i class="nav-icon bi bi-circle" style="color: #003580;"></i>
                  <p style="color: #003580;">Surat Masuk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('surat-keluar.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle" style="color: #003580;"></i>
                  <p style="color: #003580;">Surat Keluar</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('sertifikat.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-file" style="color: #003580;"></i>
              <p style="color: #003580;">Sertifikat</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('dokumen-kegiatan.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-file-fragment" style="color: #003580;"></i>
              <p style="color: #003580;">Dokumen Kegiatan</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('member.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-users" style="color: #003580;"></i>
              <p style="color: #003580;">Anggota</p>
            </a>
          </li>
          @endif
          @endif

          <!-- Bendahara Umum -->
          @if (Str::length(Auth::guard('user')->user()) > 0)
          @if (Auth::guard('user')->user()->level=="Bendahara Umum")
          <li class="nav-item">
            <a href="{{ route('beranda-bendum') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-house" style="color: #003580;"></i>
              <p style="color: #003580;">Beranda</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa-solid fa-wallet" style="color: #003580;"></i>
              <p style="color: #003580;">
                Kas Masuk
                <i class="nav-arrow bi bi-chevron-right" style="color: #003580;"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('iuran.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle" style="color: #003580;"></i>
                  <p style="color: #003580;">Iuran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('pemasukan.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle" style="color: #003580;"></i>
                  <p style="color: #003580;">Pemasukan</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('kas-keluar.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-credit-card" style="color: #003580;"></i>
              <p style="color: #003580;">Kas Keluar</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('laporan-kas.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-folder" style="color: #003580;"></i>
              <p style="color: #003580;">Laporan Kas</p>
            </a>
          </li>
          @endif
          @endif

          <!-- Anggota -->
          @if (Str::length(Auth::guard('anggota')->user()) > 0)
          @if (Auth::guard('anggota')->user()->level=="Anggota")
          <li class="nav-item">
            <a href="{{ route('beranda-anggota') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-house" style="color: #003580;"></i>
              <p style="color: #003580;">Beranda</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa-solid fa-envelope" style="color: #003580;"></i>
              <p style="color: #003580;">
                Surat-menyurat
                <i class="nav-arrow bi bi-chevron-right" style="color: #003580;"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('surat-masuk-anggota.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle" style="color: #003580;"></i>
                  <p style="color: #003580;">Surat Masuk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('surat-keluar-anggota.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle" style="color: #003580;"></i>
                  <p style="color: #003580;">Surat Keluar</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('sertifikat-anggota.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-file" style="color: #003580;"></i>
              <p style="color: #003580;">Sertifikat</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('dokumen-kegiatan-anggota.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-file-fragment" style="color: #003580;"></i>
              <i class=""></i>
              <p style="color: #003580;">Dokumen Kegiatan</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('member-anggota.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-users" style="color: #003580;"></i>
              <p style="color: #003580;">Anggota</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa-solid fa-wallet" style="color: #003580;"></i>
              <p style="color: #003580;">
                Kas Masuk
                <i class="nav-arrow bi bi-chevron-right" style="color: #003580;"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('iuran-anggota.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle" style="color: #003580;"></i>
                  <p style="color: #003580;">Iuran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('pemasukan-anggota.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle" style="color: #003580;"></i>
                  <p style="color: #003580;">Pemasukan</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('kas-keluar-anggota.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-credit-card" style="color: #003580;"></i>
              <p style="color: #003580;">Kas Keluar</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('laporan-kas-anggota.index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-folder" style="color: #003580;"></i>
              <p style="color: #003580;">Laporan Kas</p>
            </a>
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
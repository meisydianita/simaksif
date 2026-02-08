<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header</title>
</head>

<body>
  <!--begin::Header-->
  <nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">

      <!--begin::Start Navbar Links-->
      <ul class="navbar-nav d-flex flex-row align-items-center">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center" data-lte-toggle="sidebar" href="#" role="button">
            <i class="bi bi-list"></i>
          </a>
        </li>
        <li class="nav-item d-none d-md-block">
          <a href="{{ route('beranda-sekum') }}" class="nav-link d-flex align-items-center p-0">
            <span class="text-primary">Home</span>
            <span class="mx-1 text-muted">/</span>
            <span class="text-muted">
              {{ ucwords(str_replace('-', ' ', basename(request()->path()))) }}
            </span>
          </a>
        </li>
      </ul>
      <!--end::Start Navbar Links-->

      <!--begin::End Navbar Links-->
      <ul class="navbar-nav ms-auto">
        <!--begin::Messages Dropdown Menu-->
        <!--begin::Fullscreen Toggle-->
        <li class="nav-item">
          <a class="nav-link" href="#" data-lte-toggle="fullscreen">
            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
          </a>
        </li>
        <!--end::Fullscreen Toggle-->
        <!--begin::End Navbar links-->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <button
              class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center"
              id="bd-theme"
              type="button"
              aria-expanded="false"
              data-bs-toggle="dropdown"
              data-bs-display="static">
              <span class="theme-icon-active">
                <i class="my-1"></i>
              </span>
              <span class="d-lg-none ms-2" id="bd-theme-text">Toggle theme</span>
            </button>
            <ul
              class="dropdown-menu dropdown-menu-end"
              aria-labelledby="bd-theme-text"
              style="--bs-dropdown-min-width: 8rem;">
              <li>
                <button
                  type="button"
                  class="dropdown-item d-flex align-items-center active"
                  data-bs-theme-value="light"
                  aria-pressed="false">
                  <i class="bi bi-sun-fill me-2"></i>
                  Light
                  <i class="bi bi-check-lg ms-auto d-none"></i>
                </button>
              </li>
              <li>
                <button
                  type="button"
                  class="dropdown-item d-flex align-items-center"
                  data-bs-theme-value="dark"
                  aria-pressed="false">
                  <i class="bi bi-moon-fill me-2"></i>
                  Dark
                  <i class="bi bi-check-lg ms-auto d-none"></i>
                </button>
              </li>
            </ul>
          </li>
        </ul>
        <!--end::End Navbar links-->

        <!--begin::User Menu Dropdown-->
        <li class="nav-item dropdown user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            @php
            $authUser = null;
            $photoPath = null;

            if (Auth::guard('user')->check()) {
            $authUser = Auth::guard('user')->user();
            $photoPath = 'Profil/User/';
            } elseif (Auth::guard('anggota')->check()) {
            $authUser = Auth::guard('anggota')->user();
            $photoPath = 'Profil/Anggota/';
            }
            @endphp

            <img
              src="{{ $authUser && $authUser->photo
                ? asset('storage/' . $photoPath . $authUser->photo)
                : asset('img/admin.png')}}"
              class="user-image rounded-circle shadow"
              alt="User Image" />

            <span class="d-none d-md-inline">
              @if(Auth::guard('user')->check())
              {{ Auth::guard('user')->user()->name }}
              @elseif(Auth::guard('anggota')->check())
              {{ Auth::guard('anggota')->user()->name }}
              @endif
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <!--begin::User Image-->
            <li class="user-header" style="background-color: #003580; color: white;">
              @php
              $authUser = null;
              $photoPath = null;

              if (Auth::guard('user')->check()) {
              $authUser = Auth::guard('user')->user();
              $photoPath = 'Profil/User/';
              } elseif (Auth::guard('anggota')->check()) {
              $authUser = Auth::guard('anggota')->user();
              $photoPath = 'Profil/Anggota/';
              }
              @endphp

              <img
                src="{{ $authUser && $authUser->photo
                ? asset('storage/' . $photoPath . $authUser->photo)
                : asset('img/admin.png')}}"
                class="user-image rounded-circle shadow"
                alt="User Image" />
              <p>
                {{ Auth::guard('user')->check()
                          ? Auth::guard('user')->user()->name
                          : Auth::guard('anggota')->user()->name
                      }}
                @php
                $authUser = null;

                if (Auth::guard('user')->check()) {
                $authUser = Auth::guard('user')->user();
                } elseif (Auth::guard('anggota')->check()) {
                $authUser = Auth::guard('anggota')->user();
                }
                @endphp
                @if ($authUser)
                <small>Bergabung Sejak {{ $authUser->created_at->translatedFormat('M Y') }}</small>
                @endif
              </p>
            </li>
            <!--end::User Image-->
            <!--begin::Menu Footer-->
            <li class="user-footer">
              @auth('user')
              @php
              $user = Auth::guard('user')->user();
              @endphp

              @if($user->level == 'Sekretaris Umum')
              <a href="{{ route('profil-sekum') }}" class="btn btn-default btn-flat">Profil</a>
              @elseif($user->level == 'Bendahara Umum')
              <a href="{{ route('profil-bendum') }}" class="btn btn-default btn-flat">Profil</a>
              @endif
              @endauth

              @auth('anggota')
              <a href="{{ route('profil-anggota') }}" class="btn btn-default btn-flat">Profil</a>
              @endauth
              
              <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-default btn-flat float-end">
                  Keluar
                </button>
              </form>
            </li>
            <!--end::Menu Footer-->
          </ul>
        </li>
        <!--end::User Menu Dropdown-->
      </ul>
      <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
  </nav>
  <!--end::Header-->
</body>

</html>
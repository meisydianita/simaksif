<!doctype html>
<html lang="id">
@include('layout.head')
<!--begin::Body-->

<body class="fixed-header sidebar-expand-lg sidebar-open bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    @include('layout.header')
    @include ('layout.sidebar')
    <!--begin::App Main-->
    <main class="app-main">
      <!--begin::App Content-->
      <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid pt-4">
          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="card h-100">
                <div class="card-body text-center p-4">
                  <div class="position-relative d-inline-block mb-3">
                    <img
                      src="{{ $user->photo 
                      ? asset('storage/Profil/User/' . $user->photo) 
                      : asset('img/admin.png') }}"
                      alt="Foto Profil"
                      class="rounded-circle shadow"
                      width="120"
                      height="120"
                      style="object-fit: cover;">
                  </div>
                  <h6 class="fw-bold mb-1">{{ $user->name }}</h6>
                  <p class="text-muted mb-4">{{ $user->level }}</p>
                  <div class="d-grid gap-2">
                    <a href="{{ route('profil-sekum') }}"
                      style="color: inherit; text-decoration: none;"
                      class="btn btn-light btn-sm text-start fs-10">
                      <i class="bi bi-person me-2"></i> Informasi Pribadi
                    </a>
                    <button class="btn btn-light btn-sm text-start fs-10 fw-medium">
                      <i class="bi bi-lock me-2"></i> Ubah Kata Sandi
                    </button>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-md-8 mb-3">
              <div class="card h-100">
                <div class="card-header fs-6 fw-medium">
                  Ubah Kata Sandi
                </div>
                <form class="needs-validation" action="{{ route('sekum-update-sandi') }}" method="post">
                  @csrf
                  @method('PUT')
                  <div class="card-body">
                    <div class="row g-3">
                      <div class="col-md-12">
                        <label for="validationCustom02" class="form-label">Kata Sandi Lama</label>
                        <input
                          type="password"
                          class="form-control form-control-sm"
                          name="old_password"
                          placeholder="Masukkan Kata Sandi Lama"
                          required />
                      </div>

                      <div class="col-md-12">
                        <label for="validationCustom02" class="form-label">Kata Sandi Baru</label>
                        <input
                          type="password"
                          class="form-control form-control-sm"
                          name="password"
                          placeholder="Masukkan Kata Sandi Baru"
                          required />
                      </div>

                      <div class="col-md-12">
                        <label for="validationCustom02" class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <input
                          type="password"
                          class="form-control form-control-sm"
                          name="password_confirmation"
                          placeholder="Konfirmasi Kata Sandi Baru"
                          required />
                      </div>

                      <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('ubah-sandi-sekum') }}" class="btn btn-sm btn-orange-custom btn-uniform">Batal</a>
                        <button class="btn btn-sm btn-blue-custom btn-uniform" type="submit">Kirim</button>
                      </div>

                    </div>
                  </div>

                </form>

              </div>
            </div>

          </div>

        </div>
      </div>
      <!--end::App Content-->
    </main>
    <!--end::App Main-->
    @include('layout.footer')
  </div>
  <!--end::App Wrapper-->
  @include('layout.script')

</body>
<!--end::Body-->

</html>
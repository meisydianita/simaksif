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
                      : asset('AdminLTE/dist/assets/img/mee.png') }}"
                      alt="Foto Profil"
                      class="rounded-circle shadow"
                      width="120"
                      height="120"
                      style="object-fit: cover;">                    
                  </div>
                  <h6 class="fw-bold mb-1">{{ $user->name }}</h6>
                  <p class="text-muted mb-4">{{ $user->level }}</p>
                  <div class="d-grid gap-2">
                    <button class="btn btn-light btn-sm text-start fs-10 fw-medium">
                      <i class="bi bi-person me-2"></i> Informasi Pribadi
                    </button>
                    <a href="{{ route('ubah-sandi-sekum') }}" style="color:inherit; text-decoration:none;" 
                    class="btn btn-light btn-sm text-start fs-10">
                    <i class="bi bi-lock me-2"></i> Ubah Kata Sandi
                  </a>
                  </div>

                </div>
              </div>
            </div>
            
            <div class="col-md-8 mb-3">
              <div class="card h-100">
                <div class="card-header fs-6 fw-medium">
                  Detail Peserta
                  <div class="card-tools">
                    <a href="{{ route('edit-profil-sekum') }}" style="text-decoration: none; color: inherit;"><i class="fas fa-pen"></i></a>
                  </div>
                </div>
                
                  <div class="card-body">              
                    <div class="row mb-2">
                      <div class="col-md-4 text-muted">Nama</div>
                      <div class="col-md-8 fw-medium">: {{ $user->name }}</div>
                    </div>

                    <div class="row mb-2">
                      <div class="col-md-4 text-muted">Email</div>
                      <div class="col-md-8 fw-medium">: {{ $user->email }}</div>
                    </div>

                    <div class="row mb-2">
                      <div class="col-md-4 text-muted">Level</div>
                      <div class="col-md-8 fw-medium">: {{ $user->level }}</div>
                    </div>

                    <div class="row mb-2">
                      <div class="col-md-4 text-muted">Bergabung Sejak</div>
                      <div class="col-md-8 fw-medium">: {{ $user->created_at->format('d-m-Y') }}</div>
                    </div>

                  </div>
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
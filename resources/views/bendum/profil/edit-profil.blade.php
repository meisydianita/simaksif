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
          <!--begin::Row-->
          <div class="row">
            <div class="col-12">
              <!-- Default box -->
              <div class="card">
                <div class="card-header">
                  <!--begin::Form-->
                  <form class="needs-validation" action="{{ route('bendum.user.update', $user->id) }}" method="post" enctype="multipart/form-data" data-success>
                    @csrf
                    @method('PUT')
                    <!--begin::Body-->
                    <div class="card-body">
                      <!--begin::Row-->
                      <div class="row g-3">
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Nama</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $user->name }}"
                            aria-label=".form-control-sm example"
                            name="name"
                            required />
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Email</label>
                          <input
                            type="email"
                            class="form-control form-control-sm"
                            name="email"
                            required
                            value="{{ $user->email }}" />
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col">
                          <label for="formFile" class="form-label">Ubah Foto Profil</label>
                          <input class="form-control form-control-sm" type="file" id="formFile" name="photo">
                        </div>

                        <!--begin::Col-->
                        <div class="d-flex justify-content-center gap-2">
                          <a href="{{ route('profil-bendum') }}" class="btn btn-sm btn-orange-custom btn-uniform">Batal</a>
                          <button class="btn btn-sm btn-blue-custom btn-uniform" type="submit">Simpan</button>
                        </div>
                        <!--end::Col-->
                      </div>
                      <!--end::Row-->
                    </div>
                    <!--end::Body-->
                  </form>
                  <!--end::Form-->

                </div>
                <!-- /.card -->
              </div>
            </div>
            <!--end::Row-->
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
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
                <!--begin::Form-->
                <form class="needs-validation">

                  <!--begin::Body-->
                  <div class="card-body">
                    <!--begin::Row-->
                    <div class="row g-3">

                      <!--begin::Col-->
                      <div class="col-md-12">
                        <label for="validationCustom02" class="form-label">Tanggal Awal</label>
                        <input
                          type="date"
                          class="form-control form-control-sm"
                          name="tanggal_awal"
                          id="tanggal_awal"
                          required />
                      </div>
                      <!--end::Col-->

                      <!--begin::Col-->
                      <div class="col-md-12">
                        <label for="validationCustom02" class="form-label">Tanggal Akhir</label>
                        <input
                          type="date"
                          class="form-control form-control-sm"
                          name="tanggal_akhir"
                          id="tanggal_akhir"
                          required />
                      </div>
                      <!--end::Col-->

                      <!--begin::Col-->
                      <div class="d-flex justify-content-end">
                        <a class="btn btn-sm btn-blue-custom" onclick="this.href='/cetak-laporan-kas/'
                            + document.getElementById('tanggal_awal').value
                            +'/'
                            + document.getElementById('tanggal_akhir').value"
                          target="_blank">Cetak</a>
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
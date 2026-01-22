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
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-12">
                <!-- Default box -->
                <div class="card">
                  <div class="card-header">
                  <!--begin::Form-->
                  <form class="needs-validation" action="{{ route('surat-masuk.update', $surat_masuk->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!--begin::Body-->
                    <div class="card-body">
                      <!--begin::Row-->
                      <div class="row g-3">
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Nomor Surat</label>
                            <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $surat_masuk->nomor_surat }}"
                            aria-label=".form-control-sm example"
                            name="nomor_surat"
                            required
                            />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Tanggal Surat</label>
                          <input
                            type="date"
                            class="form-control form-control-sm"
                            name="tanggal_surat"
                            required
                            value="{{ $surat_masuk->tanggal_surat }}"
                          />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Asal Surat</label>
                            <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $surat_masuk->asal_surat }}"
                            aria-label=".form-control-sm example"
                            name="asal_surat"
                            required
                            />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Perihal</label>
                            <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $surat_masuk->perihal }}"
                            aria-label=".form-control-sm example"
                            name="perihal"
                            required
                            />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col">
                            <label for="formFile" class="form-label">Ubah Dokumen</label>
                              <input class="form-control form-control-sm" type="file" id="formFile" name="file_surat">
                            <!-- info file lama -->
                        </div>

                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('surat-masuk.index') }}" class="btn btn-sm btn-outline-secondary">Batal</a>
                            <button class="btn btn-sm btn-dark" type="submit" >Simpan</button> 
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

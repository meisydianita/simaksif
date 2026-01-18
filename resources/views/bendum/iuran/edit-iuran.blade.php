<!doctype html>
<html lang="en">
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
                  @if ($errors->any())
                    <div class="alert alert-danger">
                      <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                    <!--begin::Form-->
                  <form class="needs-validation" action="{{ route('iuran.update', $iuran->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!--begin::Body-->
                    <div class="card-body">
                      <!--begin::Row-->
                      <div class="row g-3">
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Tanggal Bayar</label>
                          <input
                            type="date"
                            class="form-control form-control-sm"
                            name="tanggal_bayar"
                            value="{{ $iuran->tanggal_bayar }}"
                            required                            
                          />
                        </div>
                        <!--end::Col-->   

                        <!--begin::Col -->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Status</label>
                        <select 
                        class="form-select form-select-sm" 
                        aria-label="Small select example" 
                        name="status">
                          <option disabled selected value="">Pilih Status</option>
                          <option @if($iuran->status == 'lunas') selected @endif value="lunas">Lunas</option>
                          <option @if($iuran->status == 'belum_lunas') selected @endif value="belum_lunas">Belum Lunas</option>                       
                        </select>
                        </div>
                        <!--end::Col -->

                        <div class="col-md-12">
                            <label for="formFile" class="form-label">Unggah Bukti</label>
                            <input class="form-control form-control-sm" type="file" id="formFile" name="bukti">
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->

                        <div class="d-flex justify-content-center gap-2">                            
                            <a href="{{ route('iurandetail.show', $iuran->member_id) }}" 
                              class="btn btn-sm btn-outline-secondary">Batal</a>
                            <button class="btn btn-sm btn-dark" type="submit">Kirim</button> 
                        </div>
                        <!--end::Col-->

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

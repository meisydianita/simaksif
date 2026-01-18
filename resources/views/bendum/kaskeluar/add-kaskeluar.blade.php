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
      <main class="app-main pt-4">
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
                  <form class="needs-validation" action="{{ route('kaskeluar.store') }}" method="post" enctype="multipart/form-data">
                  @csrf  
                  <!--begin::Body-->
                    <div class="card-body">
                      <!--begin::Row-->
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Nomor Pengeluaran</label>
                            <input
                            class="form-control form-control-sm"
                            type="text"
                            placeholder="Masukkan Nama Pengeluaran"
                            aria-label=".form-control-sm example"
                            name="nomor_pengeluaran"
                            required
                            />
                        </div>

                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Nama Pengeluaran</label>
                            <input
                            class="form-control form-control-sm"
                            type="text"
                            placeholder="Masukkan Nama Pengeluaran"
                            aria-label=".form-control-sm example"
                            name="nama_pengeluaran"
                            required
                            />
                        </div>

                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Tanggal Pengeluaran</label>
                          <input
                            type="date"
                            class="form-control form-control-sm"
                            name="tanggal_pengeluaran"
                            required
                          />
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Penerima Dana</label>
                            <input
                            class="form-control form-control-sm"
                            type="text"
                            placeholder="Masukkan Penerima Dana"
                            aria-label=".form-control-sm example"
                            name="penerima"
                            required
                            />
                        </div>
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Jumlah</label>
                            <input
                            class="form-control form-control-sm"
                            type="number"
                            placeholder="Masukkan Jumlah"
                            aria-label=".form-control-sm example"
                            max="99999999999999.99"
                            name="jumlah"
                            />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col -->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Kategori</label>
                        <select class="form-select form-select-sm" aria-label="Small select example" name="kategori">
                          <option disabled selected value="">Pilih Kategori</option>
                          <option value="proker_skala_kecil">Kegiatan Berskala Kecil</option>
                          <option value="proker_skala_besar">Kegiatan Berskala Besar</option>
                          <option value="dana_lain">Pendanaan Lain-lain</option>
                        </select>
                        </div>
                        <!--end::Col -->

                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Keterangan</label>
                            <input
                            class="form-control form-control-sm"
                            type="text"
                            placeholder="Masukkan Keterangan"
                            aria-label=".form-control-sm example"
                            name="keterangan"
                            />
                        </div>

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="bukti" class="form-label">Unggah Bukti</label>
                            <input class="form-control form-control-sm" type="file" id="bukti" name="bukti" accept="image/*" >
                        </div>
                        <!--end::Col-->                     

                        <!--begin::Col-->
                        <div class="d-flex justify-content-center gap-2">                        
                            <a href="{{ route('kaskeluar.index') }}" class="btn btn-sm btn-outline-secondary">Batal</a>
                            <button class="btn btn-sm btn-dark" type="submit">Kirim</button> 
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

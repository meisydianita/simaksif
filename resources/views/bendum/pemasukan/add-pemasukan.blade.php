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
                  <form class="needs-validation" action="{{ route('pemasukan.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                      <!--begin::Row-->
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Nomor Pemasukan</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            placeholder="Masukkan Nomor Pemasukan"
                            aria-label=".form-control-sm example"
                            name="nomor_pemasukan"
                            required />
                        </div>

                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Nama Pemasukan</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            placeholder="Masukkan Nama Pemasukan"
                            aria-label=".form-control-sm example"
                            name="nama_pemasukan"
                            required />
                        </div>

                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Tanggal Pemasukan</label>
                          <input
                            type="date"
                            class="form-control form-control-sm"
                            name="tanggal_pemasukan"
                            required />
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Sumber Pemasukan</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            placeholder="Masukkan Sumber Pemasukan"
                            aria-label=".form-control-sm example"
                            name="sumber_pemasukan"
                            required />
                        </div>
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Jumlah</label>
                          <input
                            class="form-control form-control-sm"
                            type="number"
                            placeholder="Masukkan Jumlah"
                            aria-label=".form-control-sm example"
                            max="99999999999999.99"
                            name="jumlah" />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col -->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Kategori</label>
                          <select class="form-select form-select-sm" aria-label="Small select example" name="kategori">
                            <option disabled selected value="">Pilih Kategori</option>
                            <option value="dana_universitas">Dana Universitas</option>
                            <option value="donasi_umum">Donasi Umum</option>
                            <option value="sumbangan_anggota">Sumbangan Anggota</option>
                            <option value="usaha_kewirausahaan">Usaha dan Kewirausahaan</option>
                            <option value="sponsor">Sponsor</option>
                            <option value="sisa_dana_kegiatan">Sisa Dana Kegiatan</option>
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
                            name="keterangan" />
                        </div>

                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="bukti" class="form-label">Unggah Bukti</label>
                          <input class="form-control form-control-sm" type="file" id="bukti" name="bukti" accept="image/*">
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="d-flex justify-content-center gap-2">
                          <a href="{{ route('pemasukan.index') }}" class="btn btn-sm btn-orange-custom">Batal</a>
                          <button class="btn btn-sm btn-blue-custom" type="submit">Kirim</button>
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
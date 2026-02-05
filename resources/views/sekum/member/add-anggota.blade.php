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
                  <form class="needs-validation" action="{{ route('member.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                      <!--begin::Row-->
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">NPM</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            placeholder="Masukkan Nomor Pokok Mahasiswa"
                            aria-label=".form-control-sm example"
                            name="npm"
                            required />
                        </div>

                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Nama Lengkap</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            placeholder="Masukkan Nama Lengkap"
                            aria-label=".form-control-sm example"
                            name="nama_lengkap"
                            required />
                        </div>
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Tahun Masuk</label>
                          <input
                            class="form-control form-control-sm"
                            type="year"
                            placeholder="Masukkan Tahun Masuk"
                            aria-label=".form-control-sm example"
                            name="tahun_masuk" />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col -->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Jabatan</label>
                          <select class="form-select form-select-sm" aria-label="Small select example" name="jabatan">
                            <option disabled selected value="">Pilih Jabatan</option>
                            <option value="ketua_umum">Ketua Umum</option>
                            <option value="sekretaris_umum">Sekretaris Umum</option>
                            <option value="bendahara_umum">Bendahara Umum</option>
                            <option value="kepala_divisi">Ketua Divisi</option>
                            <option value="sekretaris_divisi">Sekretaris Divisi</option>
                            <option value="anggota">Anggota</option>
                          </select>
                        </div>
                        <!--end::Col -->

                        <!--begin::Col -->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Divisi</label>
                          <select class="form-select form-select-sm" aria-label="Small select example" name="divisi">
                            <option disabled selected value="">Pilih Divisi</option>
                            <option value="Kaderisasi">Kaderisasi</option>
                            <option value="Kesekretariatan">Kesekretariatan</option>
                            <option value="Mebiskraf">Media Bisnis dan Kreatif</option>
                            <option value="PSDM">Peningkatan Sumber Daya Mahasiswa</option>
                            <option value="PM">Pengabdian Masyarakat</option>
                            <option value="Kerohanian">Kerohanian</option>
                          </select>
                        </div>
                        <!--end::Col -->

                        <!--begin::Col -->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Status</label>
                          <select class="form-select form-select-sm" aria-label="Small select example" name="status" required>
                            <option disabled selected value="">Pilih Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="tidak_aktif">Tidak Aktif</option>
                          </select>
                        </div>
                        <!--end::Col -->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Email</label>
                          <input
                            class="form-control form-control-sm"
                            type="email"
                            placeholder="Masukkan Email"
                            aria-label=".form-control-sm example"
                            name="email" />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">No. Telepon</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            placeholder="Masukkan No. Telepon"
                            aria-label=".form-control-sm example"
                            name="no_hp" />
                        </div>

                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Alamat</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            placeholder="Masukkan Alamat"
                            aria-label=".form-control-sm example"
                            name="alamat" />
                        </div>
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="foto" class="form-label">Unggah Foto</label>
                          <input class="form-control form-control-sm" type="file" id="foto" name="foto" accept="image/*">
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="d-flex justify-content-center gap-2">
                          <a href="{{ route('member.index') }}" class="btn btn-sm btn-orange-custom btn-uniform">Batal</a>
                          <button class="btn btn-sm btn-blue-custom btn-uniform" type="submit">Kirim</button>
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
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
              @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              <div class="card">
                <div class="card-header">
                  <!--begin::Form-->
                  <form class="needs-validation" action="{{ route('dokumen-kegiatan.update', $dokumen_kegiatan->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!--begin::Body-->
                    <div class="card-body">
                      <!--begin::Row-->
                      <div class="row g-3">
                        <!--begin::Col -->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Nama Kegiatan</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $dokumen_kegiatan->nama_kegiatan }}"
                            aria-label=".form-control-sm example"
                            name="nama_kegiatan"
                            required />
                        </div>
                        <!--end::Col -->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Tanggal Mulai</label>
                          <input
                            type="date"
                            class="form-control form-control-sm"
                            name="tanggal_mulai"
                            value="{{ $dokumen_kegiatan->tanggal_mulai }}"
                            required />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Tanggal Selesai</label>
                          <input
                            type="date"
                            class="form-control form-control-sm"
                            name="tanggal_selesai"
                            value="{{ $dokumen_kegiatan->tanggal_selesai }}"
                            required />
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Penanggungjawab</label>
                          <select name="member_id" id="" class="form-select form-select-sm">
                            @foreach ($penanggungjawab as $p)
                            <option
                              value="{{ $p->id }}"
                              {{ old('member_id', $dokumen_kegiatan->member_id) == $p->id ? 'selected' : '' }}>
                              {{ $p->nama_lengkap }}
                            </option>
                            @endforeach
                          </select>
                        </div>

                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Tahun</label>
                          <input
                            type="year"
                            class="form-control form-control-sm"
                            name="tahun"
                            value="{{ $dokumen_kegiatan->tahun }}"
                            required />
                        </div>
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Deskripsi Kegiatan</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            name="deskripsi_kegiatan"
                            value="{{ $dokumen_kegiatan->deskripsi_kegiatan }}"
                            required />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="formFile" class="form-label">Unggah Proposal</label>
                          <input class="form-control form-control-sm" type="file" id="formFile" name="proposal">
                        </div>
                        <div class="col-md-6">
                          <label for="formFile" class="form-label">Unggah Laporan Pertanggungjawaban</label>
                          <input class="form-control form-control-sm" type="file" id="formFile" name="laporan_pertanggungjawaban">
                        </div>

                        <div class="d-flex justify-content-center gap-2">
                          <a href="{{ route('dokumen-kegiatan.index') }}" class="btn btn-sm btn-outline-secondary">Batal</a>
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
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
                  <form class="needs-validation" action="{{ route('sertifikat.update', $sertifikat->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!--begin::Body-->
                    <div class="card-body">
                      <!--begin::Row-->
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Nomor Sertifikat</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            name="nomor_sertifikat"
                            value="{{ $sertifikat->nomor_sertifikat }}"
                            aria-label=".form-control-sm example"
                            required />
                        </div>

                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Nama Penerima</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $sertifikat->nama_penerima }}"
                            aria-label=".form-control-sm example"
                            name="nama_penerima" />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col -->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Peran Penerima</label>
                          <select
                            class="form-select form-select-sm"
                            aria-label="Small select example"
                            name="peran_penerima"
                            value="{{ $sertifikat->peran_penerima }}"
                            required>
                            <option disabled selected value="">Pilih Peran Penerima</option>
                            <option @if($sertifikat->peran_penerima == 'Pemateri') selected @endif value="Pemateri">Pemateri</option>
                            <option @if($sertifikat->peran_penerima == 'Peserta') selected @endif value="Peserta">Peserta</option>
                            <option @if($sertifikat->peran_penerima == 'Panitia') selected @endif value="Panitia">Panitia</option>
                          </select>
                        </div>
                        <!--end::Col -->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Nama Kegiatan</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $sertifikat->nama_kegiatan }}"
                            aria-label=".form-control-sm example"
                            name="nama_kegiatan"
                            required />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Tanggal Sertifikat</label>
                          <input
                            type="date"
                            class="form-control form-control-sm"
                            name="tanggal_sertifikat"
                            value="{{ $sertifikat->tanggal_sertifikat }}"
                            required />
                        </div>
                        <div class="col-md-6">
                          <label for="formFile" class="form-label">Unggah Dokumen</label>
                          <input class="form-control form-control-sm" type="file" id="formFile" name="file">
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="d-flex justify-content-center gap-2">
                          <a href="{{ route('sertifikat.index') }}" class="btn btn-sm btn-orange-custom">Batal</a>
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
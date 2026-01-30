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
                  <form class="needs-validation" action="{{ route('surat-keluar.update', $surat_keluar->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!--begin::Body-->
                    <div class="card-body">
                      <!--begin::Row-->
                      <div class="row g-3">
                        <!--begin::Col -->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Jenis</label>
                          <select
                            class="form-select form-select-sm"
                            aria-label="Small select example"
                            name="jenis_surat"
                            value="{{ $surat_keluar->jenis_surat }}"
                            required>
                            <option @if($surat_keluar->jenis_surat == 'sk_pengangkatan') selected @endif value="sk_pengangkatan">Surat Kerja Pengangkatan</option>
                            <option @if($surat_keluar->jenis_surat == 'peminjaman_tempat_barang') selected @endif value="peminjaman_tempat_barang">Peminjaman Barang/Tempat</option>
                            <option @if($surat_keluar->jenis_surat == 'izin_kegiatan') selected @endif value="izin_kegiatan">Izin Kegiatan</option>
                            <option @if($surat_keluar->jenis_surat == 'undangan') selected @endif value="undangan">Undangan</option>
                            <option @if($surat_keluar->jenis_surat == 'permohonan_dana') selected @endif value="permohonan_dana">Permohonan Dana</option>
                            <option @if($surat_keluar->jenis_surat == 'aktif_organisasi') selected @endif value="aktif_organisasi">Aktif Organisasi</option>
                            <option @if($surat_keluar->jenis_surat == 'peringatan') selected @endif value="peringatan">Peringatan</option>
                          </select>
                        </div>
                        <!--end::Col -->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Nomor Surat</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $surat_keluar->nomor_surat }}"
                            aria-label=".form-control-sm example"
                            name="nomor_surat"
                            required />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Tanggal Surat</label>
                          <input
                            type="date"
                            class="form-control form-control-sm"
                            name="tanggal_surat"
                            value="{{ $surat_keluar->tanggal_surat }}"
                            required />
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Tujuan Surat</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $surat_keluar->tujuan_surat }}"
                            aria-label=".form-control-sm example"
                            name="tujuan_surat"
                            required />
                        </div>

                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Perihal</label>
                          <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $surat_keluar->perihal }}"
                            aria-label=".form-control-sm example"
                            name="perihal"
                            required />
                        </div>

                        <div class="col-md-6">
                          <label for="formFile" class="form-label">Unggah Dokumen</label>
                          <input class="form-control form-control-sm" type="file" id="formFile" name="file_surat">
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->

                        <div class="d-flex justify-content-center gap-2">
                          <a href="{{ route('surat-keluar.index') }}" class="btn btn-sm btn-orange-custom">Batal</a>
                          <button class="btn btn-sm btn-blue-custom" type="submit">Kirim</button>
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
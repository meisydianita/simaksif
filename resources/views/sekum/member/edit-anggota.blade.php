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
                  <form class="needs-validation" action="{{ route('member.update', $member->id) }}" method="post" enctype="multipart/form-data">
                  @csrf 
                  @method('PUT') 
                  <!--begin::Body-->
                    <div class="card-body">
                      <!--begin::Row-->
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">NPM</label>
                            <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $member->npm }}"
                            aria-label=".form-control-sm example"
                            name="npm"
                            required
                            />
                        </div>

                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Nama Lengkap</label>
                            <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $member->nama_lengkap }}"
                            aria-label=".form-control-sm example"
                            name="nama_lengkap"
                            required
                            />
                        </div>
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Tahun Masuk</label>
                            <input
                            class="form-control form-control-sm"
                            type="year"
                            value="{{ $member->tahun_masuk }}"
                            aria-label=".form-control-sm example"
                            name="tahun_masuk"
                            />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col -->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Jabatan</label>
                        <select 
                        class="form-select form-select-sm" 
                        aria-label="Small select example" 
                        name="jabatan">
                          <option disabled selected value="">Pilih Jabatan</option>
                          <option @if($member->jabatan == 'ketua_umum') selected @endif value="ketua_umum">Ketua Umum</option>
                          <option @if($member->jabatan == 'sekretaris_umum') selected @endif value="sekretaris_umum">Sekretaris Umum</option>
                          <option @if($member->jabatan == 'bendahara_umum') selected @endif value="bendahara_umum">Bendahara Umum</option>
                          <option @if($member->jabatan == 'kepala_divisi') selected @endif value="kepala_divisi">Ketua Divisi</option>
                          <option @if($member->jabatan == 'sekretaris_divisi') selected @endif value="sekretaris_divisi">Sekretaris Divisi</option>
                          <option @if($member->jabatan == 'anggota') selected @endif value="anggota">Anggota</option>
                        </select>
                        </div>
                        <!--end::Col -->

                        <!--begin::Col -->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Divisi</label>
                        <select 
                        class="form-select form-select-sm" 
                        aria-label="Small select example" 
                        name="divisi">
                          <option disabled selected value="">Pilih Divisi</option>
                          <option @if($member->divisi == 'Kaderisasi') selected @endif value="Kaderisasi">Kaderisasi</option>
                          <option @if($member->divisi == 'Kesekretariatan') selected @endif value="Kesekretariatan">Kesekretariatan</option>
                          <option @if($member->divisi == 'Mebiskraf') selected @endif value="Mebiskraf">Media Bisnis dan Kreatif</option>
                          <option @if($member->divisi == 'PSDM') selected @endif value="PSDM">Peningkatan Sumber Daya Mahasiswa</option>
                          <option @if($member->divisi == 'PM') selected @endif value="PM">Pengabdian Masyarakat</option>
                          <option @if($member->divisi == 'Kerohanian') selected @endif value="Kerohanian">Kerohanian</option>
                        </select>
                        </div>
                        <!--end::Col -->

                        <!--begin::Col -->
                        <div class="col-md-6">
                          <label for="validationCustom02" class="form-label">Status</label>
                        <select 
                        class="form-select form-select-sm" 
                        aria-label="Small select example" 
                        name="status" required>
                          <option disabled selected value="">Pilih Status</option>
                          <option value="aktif" {{ old('status', $member->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                          <option value="tidak_aktif" {{ old('status', $member->status ?? '') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        </div>
                        <!--end::Col -->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Email</label>
                            <input
                            class="form-control form-control-sm"
                            type="email"
                            value="{{ $member->email }}"
                            aria-label=".form-control-sm example"
                            name="email"
                            />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">No. Telepon</label>
                            <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $member->no_hp }}"
                            aria-label=".form-control-sm example"
                            name="no_hp"
                            />
                        </div>

                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Alamat</label>
                            <input
                            class="form-control form-control-sm"
                            type="text"
                            value="{{ $member->alamat }}"
                            aria-label=".form-control-sm example"
                            name="alamat"
                            />
                        </div>
                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="foto" class="form-label">Unggah Foto</label>
                            <input class="form-control form-control-sm" type="file" id="foto" name="foto" accept="image/*" value="">
                        </div>
                        <!--end::Col-->                     

                        <!--begin::Col-->
                        <div class="d-flex justify-content-center gap-2">                        
                            <a href="{{ route('member.index') }}" class="btn btn-sm btn-outline-secondary">Batal</a>
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

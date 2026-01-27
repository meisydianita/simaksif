<!doctype html>
<html lang="id">
<title>Anggota</title>
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
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center gap-2 w-100">
                    <form action="{{ route('member.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-grow-1">
                      <!-- Search -->
                      <div class="input-group input-group-sm" style="width: 200px;">
                        <input type="text" name="search" class="form-control form-control-sm"
                          placeholder="Pencarian" id="searchInput" value="{{ request('search') }}">
                      </div>

                      <!-- Tahun Masuk -->
                      <div class="input-group input-group-sm" style="width: 200px;">
                        <select class="form-select form-select-sm" name="tahun_masuk" onchange="this.form.submit()" style="width: 200px">
                          <option value="">
                            @if(request('search') || request(''))
                            <a href="{{ route('member.index') }}" class="btn btn-lg btn-sm btn-default">
                            </a>
                            @endif
                            Pilih Tahun Masuk
                          </option>
                          @foreach($tahun_masuk as $thn)
                          <option value="{{ $thn }}" {{ request('tahun_masuk') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                          @endforeach
                        </select>
                      </div>

                      <!-- Divisi -->
                      <div class="input-group input-group-sm" style="width: 200px;">
                        <select class="form-select form-select-sm" name="divisi" onchange="this.form.submit()" style="width: 200px">
                          <option value="">
                            @if(request('search') || request(''))
                            <a href="{{ route('member.index') }}" class="btn btn-lg btn-sm btn-default">
                            </a>
                            @endif
                            Pilih Divisi
                          </option>
                          @foreach($divisi as $dvs => $d)
                          <option value="{{ $dvs }}" {{ request('divisi') == $dvs ? 'selected' : '' }}>{{ $d }}</option>
                          @endforeach
                        </select>
                      </div>

                      <!-- Status -->
                      <div class="input-group input-group-sm" style="width: 200px;">
                        <select class="form-select form-select-sm" name="status" onchange="this.form.submit()" style="width: 200px">
                          <option value="">
                            @if(request('search') || request(''))
                            <a href="{{ route('member.index') }}" class="btn btn-lg btn-sm btn-default">
                            </a>
                            @endif
                            Pilih Status
                          </option>
                          @foreach($status as $sts => $s)
                          <option value="{{ $sts }}" {{ request('status') == $sts ? 'selected' : '' }}>{{ $s }}</option>
                          @endforeach
                        </select>
                      </div>

                      <!-- Clear Button - DALAM FORM -->
                      @if(request('search') || request('tahun_masuk') || request('divisi') || request('status'))
                      <a href="{{ route('member.index') }}" class="btn btn-lg btn-sm btn-default">
                        <i class="fa-solid fa-xmark"></i>
                      </a>
                      @endif
                    </form>

                    <!-- Tambah Button - DI SAMPING FORM -->
                    <div class="ms-auto">
                      <a href="{{ route('member.create') }}" class="btn btn-sm btn-dark">Tambah</a>
                    </div>
                  </div>
                </div>

                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th class="fw-normal">No.</th>
                        <th class="fw-normal">NPM</th>
                        <th class="fw-normal">Nama Lengkap</th>
                        <th class="fw-normal">Tahun Masuk</th>
                        <th class="fw-normal">Jabatan</th>
                        <th class="fw-normal">Divisi</th>
                        <th class="fw-normal">Status</th>
                        <th class="fw-normal">Email</th>
                        <th class="fw-normal">No. Telepon</th>
                        <th class="fw-normal">Alamat</th>
                        <th class="fw-normal">Foto</th>
                        <th class="fw-normal">Kelola</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($allmember as $key=>$r)
                      <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $r->npm }}</td>
                        <td>{{ $r->nama_lengkap }}</td>
                        <td>{{ $r->tahun_masuk }}</td>
                        <td>{{ $jabatan[$r->jabatan] ?? $r->jabatan }}</td>
                        <td>{{ $r->divisi }}</td>
                        <td>
                          @php
                          $threeYearsAgo = now()->subYears(3)->year;
                          $isActive = $r->tahun_masuk >= $threeYearsAgo && $r->status == 'aktif';
                          @endphp
                          <span class="badge {{ $isActive ? 'bg-success' : 'bg-danger' }}">
                            {{ $isActive ? 'Aktif' : 'Tidak Aktif' }}
                          </span>
                        </td>
                        <td>{{ $r->email }}</td>
                        <td>{{ $r->no_hp }}</td>
                        <td>{{ $r->alamat }}</td>
                        <td>
                          <a href="{{ Storage::url('Member/'.$r->foto) }}" target="_blank" style="color:inherit;text-decoration:none;">
                            <img src="{{ Storage::url('Member/'.$r->foto) }}"
                              style="width: 50px; height: 50px;">
                          </a>
                        </td>
                        <td>
                          <form action="{{ route('member.destroy', $r->id) }}" method="POST">
                            <a href="{{ route('member.edit', $r->id) }}" style="color:inherit;text-decoration:none;">
                              <i class="fas fa-pen"></i>
                            </a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:none;">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </td>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="12" class="text-center py-4">
                          <div class="text-muted">Tidak Terdapat Data Anggota</div>
                        </td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <!-- begin pagination -->
                <div class="my-3 mx-3">
                  {{ $allmember->links() }}
                </div>
                <!-- end pagination -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.row -->
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
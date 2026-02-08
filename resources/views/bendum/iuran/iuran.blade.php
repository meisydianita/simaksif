<!doctype html>
<html lang="id">
<title>Iuran</title>
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
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center gap-2 w-100">
                    <form action="{{ route('iuran.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-grow-1">

                      <!-- Search -->
                      <div class="input-group input-group-sm" style="width: 280px;">
                        <input type="text" name="search" class="form-control form-control-sm float-left"
                          placeholder="Pencarian" id="searchInput" value="{{ request('search') }}" autocomplete="off">
                      </div>

                      <!-- Status -->
                      <div class="input-group input-group-sm" style="width: 280px;">
                        <select class="form-select form-select-sm" name="status" onchange="this.form.submit()" style="width: 200px">
                          <option value="">
                            @if(request('search') || request(''))
                            <a href="{{ route('iuran.index') }}" class="btn btn-lg btn-sm btn-default">
                            </a>
                            @endif
                            Pilih Status
                          </option>
                          @foreach($status as $sts => $s)
                          <option value="{{ $sts }}" {{ request('status') == $sts ? 'selected' : '' }}>{{ $s }}</option>
                          @endforeach
                        </select>
                      </div>
                   
                      @if(request('search') || request('status'))
                      <a href="{{ route('iuran.index') }}" class="btn btn-lg btn-sm btn-default">
                        <i class="fa-solid fa-xmark"></i>
                      </a>
                      @endif
                    </form>

                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-2">
                  <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th class="fw-normal">No.</th>
                          <th class="fw-normal">NPM</th>
                          <th class="fw-normal">Nama Mahasiswa</th>
                          <th class="fw-normal">Status Lunas</th>
                          <th class="fw-normal">Status</th>
                          <th class="fw-normal">Aksi</th>

                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($membersAll as $key =>$r)
                        <tr>
                          <td>{{ $key + 1 }}</td>
                          <td>{{ $r->npm }}</td>
                          <td>{{ $r->nama_lengkap }}</td>
                          <td>
                            @php
                            $memberIuran = $r->iurans()->count();
                            $memberBelumLunas = $r->iurans()->where('status', 'lunas')->count();
                            @endphp
                            {{ $memberBelumLunas }}/{{ $memberIuran }}
                          </td>
                          <td>
                            @if($r->status == 'aktif')
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                          </td>
                          <td>
                            <a href="{{ route('iurandetail.show', $r->id) }}" style="color: inherit;text-decoration:none;">
                              <i class="far fa-eye"></i>
                            </a>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="6" class="text-center py-4">
                            <div class="text-muted">Tidak Terdapat Data iuran</div>
                          </td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.card-body -->
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
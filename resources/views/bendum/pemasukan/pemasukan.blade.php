<!doctype html>
<html lang="id">
<title>Pemasukan</title>
@include('layout.head')
<!--begin::Body-->

<body class="fixed-header sidebar-expand-lg sidebar-open bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    @include('layout.header')
    @include ('layout.sidebar')
    <!--begin::App Main-->
    <main class="app-mainn pt-4">
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
                    <form action="{{ route('pemasukan.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-grow-1">
                      <!-- Search -->
                      <div class="input-group input-group-sm" style="width: 280px;">
                        <input type="text" name="search" class="form-control form-control-sm float-left"
                          placeholder="Pencarian" id="searchInput" value="{{ request('search') }}" autocomplete="off">
                      </div>

                      <!-- Divisi -->
                      <div class="input-group input-group-sm" style="width: 280px;">
                        <select class="form-select form-select-sm" aria-label="Small select example" style="width: 280px" ; onchange="this.form.submit()" name="kategori">
                          <option selected value="">
                            @if(request('search') || request(''))
                            <a href="{{ route('pemasukan.index') }}" class="btn btn-lg btn-sm btn-default">
                              <i class="fa-solid fa-xmark"></i>
                            </a>
                            @endif
                            Pilih Kategori
                          </option>
                          @foreach($kategori as $key => $label)
                          <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>
                            {{ $label }}
                          </option>
                          @endforeach
                        </select>
                      </div>

                      <!-- Clear Button - DALAM FORM -->
                      @if(request('search') || request('kategori'))
                      <a href="{{ route('pemasukan.index') }}" class="btn btn-lg btn-sm btn-default">
                        <i class="fa-solid fa-xmark"></i>
                      </a>
                      @endif
                    </form>

                    <!-- Tambah Button -->
                    <div class="ms-auto">
                      <a href="{{ route('pemasukan.create') }}"
                        class="btn btn-sm"
                        style="background-color:#003580; border-color:#003580; color:#fff;">
                        Tambah
                      </a>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th class="fw-normal">No.</th>
                        <th class="fw-normal">Nomor Pemasukan</th>
                        <th class="fw-normal">Nama Pemasukan</th>
                        <th class="fw-normal">Tanggal Pemasukan</th>
                        <th class="fw-normal">Kategori</th>
                        <th class="fw-normal">Sumber Pemasukan</th>
                        <th class="fw-normal">Jumlah</th>
                        <th class="fw-normal">Keterangan</th>
                        <th class="fw-normal">Bukti</th>
                        <th class="fw-normal">Kelola</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($allpemasukan as $key => $r)
                      <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $r->nomor_pemasukan }}</td>
                        <td>{{ $r->nama_pemasukan }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->tanggal_pemasukan)->format('d-m-Y') }}</td>
                        <td>{{ $kategori[$r->kategori] ?? $r->kategori }}</td>
                        <td>{{ $r->sumber_pemasukan }}</td>
                        <td>Rp. {{ number_format($r->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $r->keterangan }}</td>
                        <td>
                          <a href="{{ Storage::url('Pemasukan/'.$r->bukti) }}" target="_blank" style="color:inherit;text-decoration:none;">
                            <i class="far fa-eye"></i>
                          </a> |
                          <a href="{{ Storage::url('Pemasukan/'.$r->bukti) }}" download style="color:inherit;text-decoration:none;">
                            <i class="fas fa-download"></i>
                          </a>
                        </td>
                        <td>
                          <form action="{{ route('pemasukan.destroy', $r->id) }}" 
                          method="POST"
                          class="d-inline"
                          data-confirm="true">
                            <a href="{{ route('pemasukan.edit', $r->id) }}" style="color:inherit;text-decoration:none;">
                              <i class="fas fa-pen"></i>
                            </a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:none;">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="12" class="text-center py-4">
                          <div class="text-muted">Tidak Terdapat Data Pemasukan</div>
                        </td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <!-- begin pagination -->
                <div class="my-3 mx-3">
                  {{ $allpemasukan->links() }}
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
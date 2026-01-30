<!doctype html>
<html lang="id">
<title>Anggota Iuran Detail</title>
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
        <div class="container-fluid pt-4>
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center gap-2 w-100">

                  </div>
                  <div class="card-header">
                    <h3 class="card-title">Iuran Kas {{ $member->nama_lengkap }}</h3>
                    <div class="card-tools">
                      <button
                        type="button"
                        class="btn btn-tool"
                        data-lte-toggle="card-collapse"
                        title="Collapse">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                      <button
                        type="button"
                        class="btn btn-tool"
                        data-lte-toggle="card-remove"
                        title="Remove">
                        <i class="bi bi-x-lg"></i>
                      </button>
                      <a href="{{ route('iuran-anggota.index') }}"
                        class="btn btn-tool" title="Kembali">
                        <i class="bi bi-arrow-left"></i>
                      </a>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                    <div class="table-responsive">

                      <table class="table table-hover text-nowrap">
                        <thead>
                          <tr>
                            <th class="fw-normal">No.</th>
                            <th class="fw-normal">Bulan</th>
                            <th class="fw-normal">Tahun</th>
                            <th class="fw-normal">Jumlah</th>
                            <th class="fw-normal">Tanggal Bayar</th>
                            <th class="fw-normal">Bukti</th>
                            <th class="fw-normal">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($iurans as $key => $r)
                          <tr>
                            <td>{{ $key +1 }}</td>
                            <td>{{ $bulan[$r->bulan] }}</td>
                            <td>{{ $r->tahun }}</td>
                            <td>Rp. {{ number_format($r->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $r->tanggal_bayar ?? '-'}}</td>
                            <td>
                              @if($r->bukti)
                              <a href="{{ Storage::url('Iuran/'.$r->bukti) }}" target="_blank" style="color:inherit;text-decoration:none;">
                                <i class="far fa-eye"></i>
                              </a> |
                              <a href="{{ Storage::url('Iuran/'.$r->bukti) }}" download style="color:inherit;text-decoration:none;">
                                <i class="fas fa-download"></i>
                              </a>
                              @else
                              <span class="text-muted">-</span>
                              @endif
                            </td>
                            <td>
                              @if ($r->status == 'lunas')
                              <span class="badge bg-success">Lunas</span>
                              @else
                              <span class="badge bg-danger">Belum Lunas</span>
                              @endif
                            </td>
                          </tr>
                          @empty
                          <tr>
                            <td colspan="7" class="text-center py-4">
                              <div class="text-muted">Tidak Terdapat Data Iuran</div>
                            </td>
                          </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <!-- begin pagination -->
                  <div class="my-3 mx-3">
                    {{ $iurans->links() }}
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
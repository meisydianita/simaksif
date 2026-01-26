<!doctype html>
<html lang="id">
  <title>Anggota Surat Masuk</title>
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
                  <form action="{{ route('surat-masuk-anggota.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-grow-1">
                      <div class="input-group input-group-sm" style="width: 280px;">
                        <input 
                        type="text"
                        name="search" 
                        id="searchInput"
                        class="form-control form-control-sm float-left" 
                        placeholder="Pencarian"
                        value="{{ request('search') }}"
                        autocomplete="off">                        
                      </div>
                      
                      <!-- Clear Filter Button -->
                      @if(request('search') || request(''))
                          <a href="{{ route('surat-masuk-anggota.index') }}" class="btn btn-lg btn-sm btn-default">                          
                              <i class="fa-solid fa-xmark"></i>
                          </a>
                      @endif                      
                  </form>
                </div>
              </div> 
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                        <tr>
                          <th class="fw-normal">No.</th>
                          <th class="fw-normal">Nomor Surat</th>
                          <th class="fw-normal">Tanggal Surat</th>
                          <th class="fw-normal">Asal Surat</th>
                          <th class="fw-normal">Perihal</th>
                          <th class="fw-normal">File Surat</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($allsuratmasuk as $key => $r)
                          <tr>
                              <td>{{ $key + 1 }}</td>
                              <td>{{ $r->nomor_surat }}</td>
                              <td>{{ \Carbon\Carbon::parse($r->tanggal_surat)->Format('d-m-Y') }}</td>
                              <td>{{ $r->asal_surat }}</td>
                              <td>{{ $r->perihal }}</td>
                              <td>
                                <a href="{{ Storage::url('SuratMasuk/'.$r->file_surat) }}" target="_blank" style="color:inherit;text-decoration:none;">
                                  <i class="far fa-eye"></i>
                               </a> |
                                <a href="{{ Storage::url('SuratMasuk/'.$r->file_surat) }}" download style="color:inherit;text-decoration:none;">
                                  <i class="fas fa-download"></i>
                               </a>
                              </td>
                          </tr>
                          @empty
                          <tr>
                              <td colspan="6" class="text-center py-4">
                                  <div class="text-muted">Tidak Terdapat Data Surat Masuk</div>
                              </td>
                          </tr>                          
                        @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <!-- begin pagination -->
              <div class="my-3 mx-3">
                {{ $allsuratmasuk->links() }}
              </div>              
              <!-- end pagination -->
            </div>
            <!-- /.card -->

          </div>
        </div>
        <!-- /.row -->
        </div>
        <!--end::App Content-->

      <script>
        
      </script>
      
      </main>
      <!--end::App Main-->
      
      @include('layout.footer')
    </div>
    <!--end::App Wrapper-->
    @include('layout.script')
  </body>
  <!--end::Body-->
</html>

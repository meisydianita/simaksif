<!doctype html>
<html lang="en">
  <title>Surat Masuk</title>
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
                  <form action="{{ route('suratmasuk.index') }}" method="GET">
                      <div class="input-group input-group-sm" style="width: 250px;">
                        <input 
                        type="text"
                        name="search" 
                        id="searchInput"
                        class="form-control form-control-sm float-left" 
                        placeholder="Pencarian"
                        value="{{ request('search') }}"
                        autocomplete="off">                        
                      </div>                      
                  </form>
                  <!-- Clear Filter Button -->
                  @if(request('search') || request(''))
                      <a href="{{ route('suratmasuk.index') }}" class="btn btn-lg btn-sm btn-default">                          
                          <i class="fa-solid fa-xmark"></i>
                      </a>
                  @endif
                  <div class="ms-auto">
                          <a href="{{ route('suratmasuk.create') }}"
                            class="btn btn-sm btn-dark">
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
                          <th class="fw-normal">Nomor Surat</th>
                          <th class="fw-normal">Tanggal Surat</th>
                          <th class="fw-normal">Asal Surat</th>
                          <th class="fw-normal">Perihal</th>
                          <th class="fw-normal">File Surat</th>
                          <th class="fw-normal">Kelola</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($allsuratmasuk as $key => $r)
                          <tr>
                              <td>{{ $key + 1 }}</td>
                              <td>{{ $r->nomor_surat }}</td>
                              <td>{{ $r->tanggal_surat }}</td>
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
                              <td>
                                <form action="{{ route('suratmasuk.destroy', $r->id) }}" method="POST">
                                  <a href="{{ route('suratmasuk.edit', $r->id) }}" style="color:inherit;text-decoration:none;">
                                    <i class="fas fa-pen"></i>
                                  </a>
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" style="background:none;border:none;" class="justify-content-center">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </form>
                              </td>
                          </tr>
                          @empty
                          <tr>
                              <td colspan="7" class="text-center py-4">
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
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            
            // Enter = submit
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    this.form.submit();
                }
            });
            
            // Ketik 2+ huruf = delay 500ms lalu submit (debounce)
            let timeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    if (this.value.length >= 0) {
                        this.form.submit();
                    }
                }, 1);
            });
        });
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

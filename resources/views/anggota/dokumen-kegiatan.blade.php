<!doctype html>
<html lang="en">
  <title>Dokumen Kegiatan</title>
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
                  <form action="{{ route('dokumen-kegiatan-anggota.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-grow-1">
                  <!-- search -->
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
                  <!-- Tahun -->
                    <div class="input-group input-group-sm" style="width: 280px;">
                    <select class="form-select form-select-sm" aria-label="Small select example" style="width: 280px"; name="tahun" onchange="this.form.submit()">
                      <option selected value="">
                         <!-- Clear Filter Button -->
                            @if(request('search') || request('tahun'))
                                <a href="{{ route('dokumen-kegiatan-anggota.index') }}" class="btn btn-lg btn-sm btn-default">    
                                </a>
                            @endif
                        Pilih Tahun
                      </option>
                      @foreach($tahun as $thn)
                          <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>
                              {{ $thn }}
                          </option>
                      @endforeach
                    </select>  
                    </div>
                    <!-- Clear Filter Button -->
                      @if(request('search') || request('tahun'))
                          <a href="{{ route('dokumen-kegiatan-anggota.index') }}" class="btn btn-lg btn-sm btn-default">                          
                              <i class="fa-solid fa-xmark"></i>
                          </a>
                      @endif
                    <!-- end clear filter button -->
                  </form>
              </div>
              </div> 
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th class="fw-normal">No.</th>
                      <th class="fw-normal">Nama Kegiatan</th>
                      <th class="fw-normal">Tanggal Mulai</th>
                      <th class="fw-normal">Tanggal Selesai</th>
                      <th class="fw-normal">Penanggungjawab</th>
                      <th class="fw-normal">Tahun</th>
                      <th class="fw-normal">Deskripsi Kegiatan</th>
                      <th class="fw-normal">Proposal</th>
                      <th class="fw-normal">LPJ</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($alldokumenkegiatan as $key => $r)
                      <tr>
                        <td>{{ $key +1 }}</td>
                        <td>{{ $r->nama_kegiatan }}</td>
                        <td>{{ $r->tanggal_mulai }}</td>
                        <td>{{ $r->tanggal_selesai }}</td>
                        <td>{{ $r->penanggungjawab->nama_lengkap }}</td>
                        <td>{{ $r->tahun }}</td>
                        <td>{{ $r->deskripsi_kegiatan }}</td>
                        <td>
                          <a href="{{ Storage::url('DokumenKegiatan/Proposal/'.$r->proposal) }}" target="_blank" style="color:inherit;text-decoration:none;">
                            <i class="far fa-eye"></i>
                          </a> |
                          <a href="{{ Storage::url('DokumenKegiatan/Proposal/'.$r->proposal) }}" download style="color:inherit;text-decoration:none;">
                            <i class="fas fa-download"></i>
                          </a>
                        </td>
                        <td>
                          <a href="{{ Storage::url('DokumenKegiatan/Lpj/'.$r->laporan_pertanggungjawaban) }}" target="_blank" style="color:inherit;text-decoration:none;">
                            <i class="far fa-eye"></i>
                          </a> |
                          <a href="{{ Storage::url('DokumenKegiatan/Lpj/'.$r->laporan_pertanggungjawaban) }}" download style="color:inherit;text-decoration:none;">
                            <i class="fas fa-download"></i>
                          </a>
                        </td>
                      </tr>   
                      @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">Tidak Terdapat Data Dokumen Kegiatan</div>
                            </td>
                        </tr>                  
                    @endforelse                
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <!-- begin pagination -->
                <div class="my-3 mx-3">
                  {{ $alldokumenkegiatan->links() }}
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
            
            // Ketik 2+ huruf = delay 1ms lalu submit (debounce)
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

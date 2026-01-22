<!doctype html>
<html lang="id">
  <title>Sertifikat</title>
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
                  <form action="{{ route('sertifikat-anggota.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-grow-1">
                    <!-- Search -->
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
                  
                  <!-- Peran Penerima -->
                    <div class="input-group input-group-sm" style="width: 280px;">
                      <select class="form-select form-select-sm" aria-label="Small select example" style="width: 280px"; name="peran_penerima" onchange="this.form.submit()">
                        <option selected value="">
                             <!-- Clear Filter Button -->
                            @if(request('search') || request(''))
                                <a href="{{ route('sertifikat.index') }}" class="btn btn-lg btn-sm btn-default">    
                                </a>
                            @endif
                            Pilih Peran Penerima
                        </option>
                        @foreach ($peran_penerima as $key=> $label)
                          <option value="{{$key}}" {{ request('peran_penerima') == $key ? 'selected' : '' }}>{{$label}}</option>
                        @endforeach
                      </select>  
                    </div>
                    <!-- Clear Filter Button -->
                    @if(request('search') || request('peran_penerima'))
                        <a href="{{ route('sertifikat-anggota.index') }}" class="btn btn-lg btn-sm btn-default">                          
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
                      <th class="fw-normal" >No.</th>
                      <th class="fw-normal" >Nomor Sertifikat</th>
                      <th class="fw-normal" >Tanggal Sertifikat</th>
                      <th class="fw-normal" >Nama Penerima</th>
                      <th class="fw-normal" >Peran Penerima</th>
                      <th class="fw-normal" >Nama Kegiatan</th>
                      <th class="fw-normal" >File Surat</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($allsertifikat as $key => $r)
                      <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $r->nomor_sertifikat }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->tanggal_sertifikat)->format('d-m-Y') }}</td>
                        <td>{{ $r->nama_penerima }}</td>
                        <td>{{ $r->peran_penerima }}</td>
                        <td>{{ $r->nama_kegiatan }}</td>
                        
                        <td>
                          <a href="{{ Storage::url('Sertifikat/'.$r->file) }}" target="_blank" style="color:inherit;text-decoration:none;">
                            <i class="far fa-eye"></i>
                          </a> |
                          <a href="{{ Storage::url('Sertifikat/'.$r->file) }}" download style="color:inherit;text-decoration:none;">
                            <i class="fas fa-download"></i>
                          </a>
                        </td>                        
                      </tr>
                      @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">Tidak Terdapat Data Sertifikat</div>
                            </td>
                        </tr>   
                    @endforelse                                       
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <!-- begin pagination -->
                <div class="my-3 mx-3">
                  {{ $allsertifikat->links() }}
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

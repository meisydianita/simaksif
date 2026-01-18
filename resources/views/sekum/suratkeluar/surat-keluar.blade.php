<!doctype html>
<html lang="en">
  <title>Surat Keluar</title>
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
                      <form action="{{ route('suratkeluar.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-grow-1">
                        <!--Search  -->
                      <div class="input-group input-group-sm" style="width: 280px;">
                        <input 
                        type="text" 
                        name="search" 
                        id="searchInput"
                        class="form-control form-control-sm float-left" 
                        placeholder="Pencarian" 
                        autocomplete="off"
                        value="{{ request('search') }}">
                      </div>
                        <!-- Jenis Surat -->
                      <div class="input-group input-group-sm" style="width: 280px;">
                        <select class="form-select form-select-sm" aria-label="Small select example" style="width: 280px"; name="jenis_surat" onchange="this.form.submit()">
                              <option selected value="">
                                @if(request('search') || request(''))
                                    <a href="{{ route('suratkeluar.index') }}" class="btn btn-lg btn-sm btn-default">    
                                    </a>
                                @endif
                                Pilih Jenis Surat
                              </option>
                              @foreach($jenis_surat as $key => $label)                              
                                  <option value="{{ $key }}" {{ request('jenis_surat') == $key ? 'selected' : '' }}>
                                      {{ $label }}
                                  </option>
                              @endforeach
                        </select>  
                      </div>
                      <!-- Clear Filter Button -->
                      @if(request('search') || request(''))
                          <a href="{{ route('suratkeluar.index') }}" class="btn btn-lg btn-sm btn-default">                          
                              <i class="fa-solid fa-xmark"></i>
                          </a>
                      @endif
                      </form>
                      
                      <div class="ms-auto">
                              <a href="{{ route('suratkeluar.create') }}"
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
                              <th class="fw-normal">Jenis Surat</th>
                              <th class="fw-normal">Tanggal Surat</th>
                              <th class="fw-normal">Tujuan Surat</th>
                              <th class="fw-normal">Perihal</th>
                              <th class="fw-normal">File Surat</th>
                              <th class="fw-normal">Kelola</th>
                            </tr>
                      </thead>
                          <tbody>
                            @forelse ($allsuratkeluar as $key => $r)
                              <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $r->nomor_surat }}</td>
                                <td>{{ $jenis_surat[$r->jenis_surat] ?? $r->jenis_surat }}</td>
                                <td>{{ $r->tanggal_surat }}</td>
                                <td>{{ $r->tujuan_surat }}</td>
                                <td>{{ $r->perihal }}</td>
                                <td>
                                  <a href="{{ Storage::url('SuratKeluar/'.$r->file_surat) }}" target="_blank" style="color:inherit;text-decoration:none;">
                                      <i class="far fa-eye"></i>
                                  </a> |
                                    <a href="{{ Storage::url('SuratKeluar/'.$r->file_surat) }}" download style="color:inherit;text-decoration:none;">
                                      <i class="fas fa-download"></i>
                                  </a>
                                </td>
                                <td>
                                  <form action="{{ route('suratkeluar.destroy', $r->id) }}" method="POST">
                                      <a href="{{ route('suratkeluar.edit', $r->id) }}" style="color:inherit;text-decoration:none;">
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
                                  <td colspan="8" class="text-center py-4">
                                      <div class="text-muted">Tidak Terdapat Data Surat Keluar</div>
                                  </td>
                              </tr>    
                            @endforelse
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                  <!-- begin pagination -->
                  <div class="my-3 mx-3">
                    {{ $allsuratkeluar->links() }}
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

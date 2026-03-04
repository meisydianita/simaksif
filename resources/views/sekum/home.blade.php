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
    <main class="app-main">
      <!--begin::App Content Header-->
      <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid pt-4">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon text-bg-primary shadow-sm">
                  <i class="fa-solid fa-envelope"></i>
                </span>
                <div class="info-box-content">
                  <span class="info-box-text">Surat Masuk</span>
                  <span class="info-box-number">
                    <a href="{{ route('surat-masuk.index') }}" class="total-link">{{ $totalsuratmasuk }}</a>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon text-bg-danger shadow-sm">
                  <i class="fa-solid fa-envelope-open"></i>
                </span>
                <div class="info-box-content">
                  <span class="info-box-text">Surat Keluar</span>
                  <span class="info-box-number">
                    <a href="{{ route('surat-keluar.index') }}" class="total-link">{{ $totalsuratkeluar }}</a>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon text-bg-success shadow-sm">
                  <i class="fa-solid fa-file"></i>
                </span>
                <div class="info-box-content">
                  <span class="info-box-text">Sertifikat</span>
                  <span class="info-box-number">
                    <a href="{{ route('sertifikat.index') }}" class="total-link">{{ $totalsertifikat }}</a>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon text-bg-secondary shadow-sm">
                  <i class="fa-solid fa-file-fragment"></i>
                </span>
                <div class="info-box-content">
                  <span class="info-box-text">Dokumen Kegiatan</span>
                  <span class="info-box-number">
                    <a href="{{ route('dokumen-kegiatan.index') }}" class="total-link">{{ $totaldokumenkegiatan }}</a>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-6">
              <div class="info-box">
                <span class="info-box-icon text-bg-warning shadow-sm">
                  <i class="bi bi-people-fill"></i>
                </span>
                <div class="info-box-content">
                  <span class="info-box-text">Anggota Aktif</span>
                  <span class="info-box-number">
                    <a href="{{ route('member.index') }}" class="total-link">{{ $totalmemberaktif }}</a>
                  </span>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-6">
              <div class="info-box">
                <span class="info-box-icon text-bg-warning shadow-sm">
                  <i class="bi bi-people-fill"></i>
                </span>
                <div class="info-box-content">
                  <span class="info-box-text">Anggota Tidak Aktif</span>
                  <span class="info-box-number">
                    <a href="{{ route('member.index') }}" class="total-link">{{ $totalmembernonaktif }}</a>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->


          </div>
          <!-- /.row -->
          <!--begin::Row-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::App Content-->
      <!--begin::App Main-->
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
                  <h3 class="card-title">Grafik Tren Kas Bulanan {{ $tahunSekarang }}</h3>
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
                  </div>
                </div>
                <div class="card-body">
    <div id="grafik" style="width:100%; height:400px;"></div>
</div>
                <!-- /.card-body -->
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
  <script src="https://code.highcharts.com/12.4.0/highcharts.js"></script>
  <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
      var grafiktotalsuratmasuk = <?php echo json_encode($grafiktotalsuratmasuk) ?>;
      var grafiktotalsuratkeluar = <?php echo json_encode($grafiktotalsuratkeluar) ?>;
      var grafiktotaldokumenkegiatan = <?php echo json_encode($grafiktotaldokumenkegiatan) ?>;
      var grafiktotalsertifikat = <?php echo json_encode($grafiktotalsertifikat) ?>;
      var bulan = <?php echo json_encode($bulan) ?>;

      Highcharts.chart('grafik', {
        title: null,
        xAxis: {
          categories: bulan
        },
        yAxis: {
          title: {
            text: 'Jumlah Data'
          },
          plotOptions: {
            series: {
              allowPointSelect: true
            }
          }
        },
        series: [{
            name: 'Surat Masuk',
            data: grafiktotalsuratmasuk,
            color: '#399918'
          },
          {
            name: 'Surat Keluar',
            data: grafiktotalsuratkeluar,
            color: '#980404'
          },
          {
            name: 'Dokumen Kegiatan',
            data: grafiktotaldokumenkegiatan,
            color: '#0D1164'
          },
          {
            name: 'Sertifikat',
            data: grafiktotalsertifikat,
            color: '#F87B1B'
          }
        ]
      });

    });
  </script>
</body>
<!--end::Body-->

</html>
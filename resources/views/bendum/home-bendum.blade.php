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
            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box">
                <span class="info-box-icon text-bg-success shadow-sm">
                  <i class="fa-solid fa-wallet"></i>
                </span>
                <div class="info-box-content">
                  <span class="info-box-text">Kas Masuk</span>
                  <span class="info-box-number">
                    <a href="{{ route('pemasukan.index') }}" style="text-decoration:none; color: black;">Rp {{ number_format($totalkasmasuk, 0, ',', '.') }}</a>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box">
                <span class="info-box-icon text-bg-primary shadow-sm">
                  <i class="fa-solid fa-credit-card"></i>
                </span>
                <div class="info-box-content">
                  <span class="info-box-text">Kas Keluar</span>
                  <span class="info-box-number">
                    <a href="{{ route('kas-keluar.index') }}" style="text-decoration:none; color: black;">Rp {{ number_format($totalkaskeluar, 0, ',', '.') }}</a>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <!-- fix for small devices only -->
            <!-- <div class="clearfix hidden-md-up"></div> -->
            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box">
                <span class="info-box-icon text-bg-danger shadow-sm">
                  <i class="fa-solid fa-money-check"></i>
                </span>
                <div class="info-box-content">
                  <span class="info-box-text">Sisa Saldo</span>
                  <span class="info-box-number">
                    <a href="#" style="text-decoration:none; color: black;">Rp {{ number_format($sisasaldo, 0, ',', '.') }}</a>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

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
                <div class="card-body" id="grafik"></div>
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
    <script src="https://code.highcharts.com/12.4.0/highcharts.js"></script>
    <script type="text/javascript">
      var grafikKasMasuk = <?php echo json_encode($grafikKasMasuk) ?>;
      var grafikKasKeluar = <?php echo json_encode($grafikKasKeluar) ?>;
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
            name: 'Kas Masuk',
            data: grafikKasMasuk,
            color: '#399918'
          },
          {
            name: 'Kas Keluar',
            data: grafikKasKeluar,
            color: '#980404'
          }
        ]
      });
    </script>
    @include('layout.footer')
  </div>
  <!--end::App Wrapper-->
  @include('layout.script')
</body>
<!--end::Body-->

</html>
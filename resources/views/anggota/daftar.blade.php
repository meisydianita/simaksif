<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Daftar | HIMASIF</title>
  <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
</head>

<body class="page-register">
  <div class="register-container">
    <div class="right-panel">
      <div class="white-background">
        <div class="content-wrapper">
          <div class="form-header">
            <div class="title">Registrasi Akun</div>
            <p class="subtitle">
              Langkah kecil hari ini, perubahan besar esok hari. Yuk daftar!
            </p>
            <form action="#" method="post">
              @csrf
              <div class="form-container">
                <div class="form-card">
                  <div class="form-fields">
                    <div class="form-group">
                      <label>Nama Lengkap</label>
                      <input type="text" name="nama" placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" placeholder="Masukkan email">
                    </div>

                    <div class="form-group">
                      <label>Kata Sandi</label>
                      <input type="password" name="password" placeholder="Masukkan kata sandi">
                    </div>

                    <button class="submit-btn" type="submit">Daftar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <p class="link-text">
            Sudah memiliki akun? <span class="link"><a href="{{ route('login') }}" style="text-decoration:none; color:inherit;">Masuk</a></span>
          </p>
        </div>
      </div>
    </div>

    <img class="robot" src="{{ asset('img/robot.png') }}" alt="Robot HIMASIF">


    <h2 class="left-title">
      Berproses,<br>
      Berorganisasi,<br>
      Berinovasi Bersama<br>
      HIMASIF.
    </h2>

    <p class="left-subtitle">
      Akses semua kebutuhan administrasi dan kegiatan HIMASIF secara cepat,
      praktis, dan terpusat.
    </p>
  </div>
</body>

</html>
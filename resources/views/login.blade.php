<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | HIMASIF</title>

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
  <div class="login">
    <div class="group">
      <div class="frame">
        <div class="div">
          <div class="group-2">
            <div class="text-wrapper">Selamat Datang</div>
            <p class="p">
              Langkah kecil hari ini, perubahan besar esok hari. Yuk masuk!
            </p>
            <form action="{{ route('postlogin') }}" method="post">
              @csrf
              <div class="frame-wrapper">
                <div class="group-wrapper">
                  <div class="group-3">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}">
                      @error('email')
                        <div style="color: #e3342f; font-size: 0.875rem; margin-top: 0rem;">
                            {{ $message }}
                        </div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label>Kata Sandi</label>
                      <input type="password" name="password" placeholder="Masukkan kata sandi"  class="form-control @error('password') is-invalid @enderror"
                      value="{{ old('password') }}">
                      @error('password')
                        <div style="color: #e3342f; font-size: 0.875rem; margin-top: 0rem;">
                            {{ $message }}
                        </div>
                      @enderror
                    </div>

                    <button class="login-button" type="submit">Masuk</button>

                  </div>
                </div>
              </div>
            </form>
          </div>

          <p class="belum-memiliki-akun">
            Belum memiliki akun? <span class="text-wrapper-6"><a href="{{ route('daftar') }}" style="text-decoration:none; color:#002a66;">Daftar</a></span>
          </p>

        </div>
      </div>
    </div>

    <!-- ROBOT -->
    <img class="robot" src="{{ asset('img/robot.png') }}" alt="Robot HIMASIF">

    <!-- TEKS KIRI (POSISI ASLI) -->
    <h2 class="text-wrapper-8">
      Berproses,<br>
      Berorganisasi,<br>
      Berinovasi Bersama<br>
      HIMASIF.
    </h2>

    <p class="text-wrapper-9">
      Akses semua kebutuhan administrasi dan kegiatan HIMASIF secara cepat,
      praktis, dan terpusat.
    </p>

  </div>
</body>

</html>
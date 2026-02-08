<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
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
                      <input type="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}"
                        class="form-control-user @error('email') is-invalid @enderror
                      ">
                      @error('email')
                      <div class="error-warning">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label>Kata Sandi</label>
                      <input type="password" name="password" placeholder="Masukkan kata sandi"
                        value="{{ old('password') }}"
                        class="form-control-user @error('password') is-invalid @enderror
                      ">
                      @error('password')
                      <div class="error-warning">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>

                    <button class="login-button" type="submit">Masuk</button>
                    <div style="text-align: right;">
                      <a href="{{ route('reset-kata-sandi') }}" class="lupa-button">Lupa Kata Sandi?</a>
                    </div>

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

    <img class="robot" src="{{ asset('img/robot.png') }}" alt="Robot HIMASIF">

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
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const messages = {
        login_success: "{{ session('login_success') }}",
        error: "{{ session('login_error') }}",
        logout: "{{ session('logout') }}",
        signup_success: "{{ session('signup_success') }}"
      };

      let activeMessage = null;
      let messageType = null;

      for (const [type, message] of Object.entries(messages)) {
        if (message && message.trim() !== "") {
          activeMessage = message;

          messageType = type === 'error' ? 'error' : 'success';
          break;
        }
      }

      if (!activeMessage) return;

      const toast = document.createElement('div');
      toast.className = `toast toast-white ${messageType}`;

      toast.innerHTML = `
      <div class="toast-header">
        <div class="toast-body">${activeMessage}</div>
        <button type="button" class="btn-close">&times;</button>
      </div>
    `;

      let container = document.querySelector('.toast-container');
      if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
      }

      container.appendChild(toast);

      setTimeout(() => {
        toast.classList.add('show');
      }, 10);

      const closeBtn = toast.querySelector('.btn-close');
      closeBtn.addEventListener('click', function() {
        toast.classList.remove('show');
        setTimeout(() => {
          toast.remove();
        }, 300);
      });

      setTimeout(() => {
        if (toast.parentNode) {
          toast.classList.remove('show');
          setTimeout(() => {
            if (toast.parentNode) {
              toast.remove();
            }
          }, 300);
        }
      }, 3000);
    });
  </script>

</body>

</html>
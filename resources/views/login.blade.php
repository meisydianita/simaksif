<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | HIMASIF</title>

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    .toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
    }

    .toast {
      width: 400px;
      min-height: 40px;
      background: white;
      border-radius: 5px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      margin-bottom: 10px;
      overflow: hidden;
      opacity: 0;
      transform: translateX(100%);
      transition: all 0.3s ease;
      display: flex;
      align-items: center;

    }

    .toast.show {
      opacity: 1;
      transform: translateX(0);
    }

    .toast-header {
      padding: 0 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
    }

    .toast-body {
      padding: 0;
      flex-grow: 1;
      font-size: 16px;
      line-height: 1.5;
      font-weight: lighter;
      color: #495057;
    }

    .btn-close {
      background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23666'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/16px auto no-repeat;
      border: 0;
      width: 20px;
      height: 20px;
      padding: 0;
      cursor: pointer;
      opacity: 0.7;
      margin-left: 15px;
    }

    .btn-close:hover {
      opacity: 1;
    }

    .toast-white.success {
      border-left: 5px solid #198754;
    }

    .toast-white.error {
      border-left: 5px solid #dc3545;
    }

    .toast-white.info {
      border-left: 5px solid #003580;
    }
  </style>
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
                      <div style="color: #e3342f; font-size: 0.875rem; margin-top: 0rem;">
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const messages = {
      login_success: "{{ session('login_success') }}",
      error: "{{ session('error') }}",
      logout: "{{ session('logout') }}",
      signup_success: "{{ session('signup_success') }}"
    };

    let activeMessage = null;
    let messageType = null;

    for (const [type, message] of Object.entries(messages)) {
      if (message && message.trim() !== "") {
        activeMessage = message;
        // semua selain error → jadi class 'success'
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
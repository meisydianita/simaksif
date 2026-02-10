<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Daftar</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
            <form action="{{ route('postdaftar') }}" method="post">
              @csrf
              <div class="form-container">
                <div class="form-card">
                  <div class="form-fields">
                    <div class="form-group">
                      <label>NPM</label>
                      <input type="text" name="name" placeholder="Masukkan Nomor Pokok Mahasiswa">
                    </div>

                    <div class="form-group">
                      <label>Nama Lengkap</label>
                      <input type="text" name="name" placeholder="Masukkan nama lengkap">
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
            Sudah memiliki akun? <span class="link"><a href="{{ route('login') }}" style="text-decoration:none; color: #002a66;">Masuk</a></span>
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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const messages = {
        success: "{{ session('signup_success') }}",
        error: "{{ session('signup_error') }}"
      };

      let activeMessage = null;
      let messageType = null;
      let autoCloseTime = 3000;

      for (const [type, message] of Object.entries(messages)) {
        if (message && message.trim() !== "") {
          activeMessage = message;
          messageType = type === 'error' ? 'error' : 'success';
          autoCloseTime = (type === 'error') ? 0 : 3000;
          break;
        }
      }

      if (!activeMessage) return;

      const toast = document.createElement('div');
      toast.className = `toast toast-white ${messageType}`;

      toast.innerHTML = `
      <div class="toast-header">
        <div class="toast-body" id="toast-message"></div>
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

      const toastBody = toast.querySelector('#toast-message');
      toastBody.innerHTML = activeMessage.replace(/\n/g, '<br>');

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


      if (autoCloseTime > 0) {
        setTimeout(() => {
          if (toast.parentNode) {
            toast.classList.remove('show');
            setTimeout(() => {
              if (toast.parentNode) {
                toast.remove();
              }
            }, 300);
          }
        }, autoCloseTime);
      }
    });
  </script>

</body>

</html>
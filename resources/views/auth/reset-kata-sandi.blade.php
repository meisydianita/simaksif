<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reset Kata Sandi</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="login">
        <div class="group">
            <div class="frame reset-center">
                <div class="div">
                    <div class="group-2">
                        <div class="text-wrapper">Reset Kata Sandi</div>
                        <p class="p">
                            Masukkan alamat email Anda untuk mengatur ulang kata sandi.
                        </p>
                        <form action="{{ route('password.email') }}" method="post">
                            @csrf
                            <div class="frame-wrapper">
                                <div class="group-wrapper reset-box">
                                    <div class="group-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" placeholder="Masukkan email yang sudah terdaftar"
                                                class="form-control-user">
                                        </div>

                                        <div style="display:flex; gap:10px;">
                                            <a href="{{ route('login') }}" class="cancel-button">Batal</a>
                                            <button class="login-button" type="submit" style="flex:1;">Kirim</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

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
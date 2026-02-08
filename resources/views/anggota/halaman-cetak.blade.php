<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Kas</title>
</head>

<body>

    <div class="card-header">
        <div style="display: flex; align-items: center;">
            <div style="width: 15%; text-align: right;">
                <img src="{{asset('img/logo.png')}}" alt="Logo Himasif" style="height: 120px;">
            </div>

            <div style="width: 70%; text-align: center;">

                <h3 style="margin: 0; line-height: 1.2;">
                    KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,<br>
                    RISET, DAN TEKNOLOGI<br>
                    UNIVERSITAS BENGKULU<br>
                    FAKULTAS TEKNIK<br>
                    HIMPUNAN MAHASISWA SISTEM INFORMASI
                </h3>

                <p style="margin: 2px 0 2px 0; font-size: 13px;">
                    Sekretariat HIMASIF F. Teknik UNIB
                </p>

                <div style="
                    display: flex;
                    justify-content: center;
                    gap: 16px;
                    font-size: 12px;
                    margin-top: 0;
                ">
                    <span>
                        Website :
                        <a href="https://himasif.ft.unib.ac.id" target="_blank">
                            himasif.ft.unib.ac.id
                        </a>
                    </span>

                    <span>
                        Email :
                        <a href="mailto:himasifunib@gmail.com">
                            himasifunib@gmail.com
                        </a>
                    </span>
                </div>

            </div>

            <div style="width: 15%; text-align: left;">
                <img src="{{asset('img/logo-unib.png')}}" alt="Logo Unib" style="height: 120px;">
            </div>

        </div>
        <hr style="border: 2px solid black;">
    </div>
    <h4 style="text-align: center;">LAPORAN KAS HIMPUNAN MAHASISWA SISTEM INFORMASI</h4>

    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 8px; text-align: center;">NO.</th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;">TANGGAL</th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;">KAS MASUK</th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;">KAS KELUAR</th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;">SISA SALDO</th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @php $saldo = 0; @endphp
            @foreach ($laporanKas as $key => $item)
            @php
            $saldo += $item['masuk'] - $item['keluar'];
            @endphp
            <tr>
                <td style="border:1px solid black; text-align:center;">{{ $key+1 }}</td>
                <td style="border:1px solid black; text-align: center;">
                    {{ \Carbon\Carbon::parse($item['tanggal'])->format('d-m-Y') }}
                </td>
                <td style="border:1px solid black; text-align:left;">
                    Rp {{ number_format($item['masuk'], 0, ',', '.') }}
                </td>
                <td style="border:1px solid black; text-align:left;">
                    Rp {{ number_format($item['keluar'], 0, ',', '.') }}
                </td>
                <td style="border:1px solid black; text-align:left;">
                    Rp {{ number_format($saldo, 0, ',', '.') }}
                </td>
                <td style="border:1px solid black; text-align:left;">{{ $item['nama'] }}</td>
            </tr>
            @endforeach
            <tr class="fw-bold bg-light">

                <td colspan="2" style="border:1px solid black; text-align:left; font-weight: bold;">
                    TOTAL
                </td>
                <td style="border:1px solid black; text-align:left; font-weight: bold;">
                    Rp {{ number_format($totalMasuk, 0, ',', '.') }}
                </td>

                <td style="border:1px solid black; text-align:left; font-weight: bold;">
                    Rp {{ number_format($totalKeluar, 0, ',', '.') }}
                </td>

                <td colspan="2" style="border:1px solid black; text-align:left; font-weight: bold;">
                    SISA SALDO : Rp {{ number_format($sisaSaldo, 0, ',', '.') }}
                </td>
            </tr>

        </tbody>
    </table>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
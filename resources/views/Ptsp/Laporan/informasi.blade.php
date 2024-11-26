<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengunjung Informasi dan Layanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }
        .kop-surat img {
            width: 100%;
            height: auto;
            margin: 0;
        }
        .content {
            text-align: center;
            margin: 20px auto;
        }
        h2 {
            font-size: 16px;
        }
        .receipt-table {
            width: 70%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        .receipt-table th, .receipt-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="{{ public_path('assets/img/kop.png') }}" alt="Kop Surat">
    </div>

    <div class="content">
        <h2>Laporan Pengunjung Informasi dan Layanan Self Service Sistem (S3)</h2>
        <p>Bulan: {{ $bulanNama }}, Tahun: {{ $tahun }}</p>

        <table class="receipt-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Pekerjaan</th>
                    <th>Pendidikan</th>
                    <th>Perkara</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemohon as $item)
                    <tr>
                        <td>{{ $item['nama'] }}</td>
                        <td>{{ $item['pekerjaan'] }}</td>
                        <td>{{ $item['pendidikan'] }}</td>
                        <td>{{ $item['perkara'] }}</td>
                        <td>{{ $item['alamat'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

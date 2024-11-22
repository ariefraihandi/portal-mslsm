<!DOCTYPE html>
<html>
<head>
    <title style="text-align: center;">
        Bukti Pengajuan Permohonan Informasi atas nama {{ $pemohon->nama }}
    </title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: -20;
            padding: -20;
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
            text-align: center; /* Center the content */
            margin: 10px auto;  /* Center margin */
        }
        h2 {
            font-size: 16px;
        }
        .receipt-table {
            width: 80%; /* Adjust this width as per your needs */
            
            margin-left: auto; /* This will center the table */
            margin-right: auto; /* This will center the table */
            border: none; /* Tidak ada border */
            
        }
        .receipt-table th, .receipt-table td {
            border: none;
            font-size: 14px;
            padding: 8px;
            text-align: left; /* Align the text to the left */
        }

        .ttd-table {
        margin: auto;
        text-align: center;
        width: 80%; /* Atur lebar tabel sesuai kebutuhan */
    }
    .ttd-table td {
        border: none;
        padding: 10px;
        vertical-align: middle;
    }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="{{ public_path('assets/img/kop.png') }}" alt="Kop Surat">
    </div>

    <div class="content">
        <h2>Bukti Pengajuan Permohonan Informasi</h2>
        <h3>Model A- Untuk Prosedur Biasa</h3>
    
        <table class="receipt-table">
            <tr>
                <td style="width: 45%; text-align: left;"><strong>Tanggal Pengajuan Permohonan</strong></td>
                <td style="width: 5%; text-align: center;">:</td>
                <td style="width: 50%;">
                    {{ $pemohon->created_at ? \Carbon\Carbon::parse($pemohon->created_at)->translatedFormat('d F Y') : 'N/A' }}
                </td>
            </tr>
            <tr>
                <td style="width: 45%; text-align: left;"><strong>Tanggal Pemberitahuan Tertulis</strong></td>
                <td style="width: 5%; text-align: center;">:</td>
                <td style="width: 50%;">
                    {{ $pemohon->created_at ? \Carbon\Carbon::parse($pemohon->created_at)->translatedFormat('d F Y') : 'N/A' }}
                </td>
            </tr>
            <tr>
                <td style="width: 45%; text-align: left;"><strong>Nomor Pendaftaran</strong></td>
                <td style="width: 5%; text-align: center;">:</td>
                <td style="width: 50%;">{{ $pemohon->id ?? 'N/A' }}/PTSP/Informasi</td>
            </tr>
            <tr>
                <td style="width: 45%; text-align: left;"><strong>Nama</strong></td>
                <td style="width: 5%; text-align: center;">:</td>
                <td style="width: 50%;">{{ $pemohon->nama ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="width: 45%; text-align: left;"><strong>Alamat</strong></td>
                <td style="width: 5%; text-align: center;">:</td>
                <td style="width: 50%;">{{ $pemohon->alamat ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="width: 45%; text-align: left;"><strong>Pekerjaan</strong></td>
                <td style="width: 5%; text-align: center;">:</td>
                <td style="width: 50%;">{{ $pemohon->pekerjaan->nama_pekerjaan ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="width: 45%; text-align: left;"><strong>Nomor Telepon/Email</strong></td>
                <td style="width: 5%; text-align: center;">:</td>
                <td style="width: 50%;">{{ $pemohon->email ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="width: 45%; text-align: left;"><strong>Rincian Informasi Yang Dibutuhkan</strong></td>
                <td style="width: 5%; text-align: center;">:</td>
                <td style="width: 50%;">{{ $pemohon->rincian_informasi ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="width: 45%; text-align: left;"><strong>Tujuan Penggunaan Informasi</strong></td>
                <td style="width: 5%; text-align: center;">:</td>
                <td style="width: 50%;">{{ $pemohon->tujuan_penggunaan ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="width: 45%; text-align: left;"><strong>Cara Memperoleh Informasi</strong></td>
                <td style="width: 5%; text-align: center;">:</td>
                <td style="width: 50%;">
                    <img src="{{ public_path('assets/svg/icons/checked.png') }}" width="16" height="16" alt="Checklist">
                    Melihat/Membaca/Mendengarkan
                </td>
            </tr>
            <tr>
                <td style="width: 45%; text-align: left;"><strong></strong></td>
                <td style="width: 5%; text-align: center;"></td>
                <td style="width: 50%;">
                    <img src="{{ public_path('assets/svg/icons/checked.png') }}" width="16" height="16" alt="Checklist">
                    Mendapatkan Salinan Informasi Elektronik
                </td>
            </tr>
            <tr>
                <td style="width: 45%; text-align: left;"><strong>Cara Mendapatkan Informasi</strong></td>
                <td style="width: 5%; text-align: center;">:</td>
                <td style="width: 50%;">
                    <img src="{{ public_path('assets/svg/icons/check-box-empty.png') }}" width="16" height="16" alt="Checklist">
                    Mengambil Langsung
                    <img src="{{ public_path('assets/svg/icons/checked.png') }}" width="16" height="16" alt="Checklist">
                    Whatsapp
                </td>
            </tr>
           
        </table>
          <br>
          <br>
          <table class="ttd-table">
            <tr>                
                <td>Petugas Informasi</td>
                <td></td>                
                <td>Pemohon Informasi</td>
            </tr>
            <tr>
                <!-- Empty rows for signature area -->
                <td>
                    <img src="data:image/svg+xml;base64,{{ $qrCodePetugas }}" alt="QR Code" />
                </td>
                <td>&nbsp;</td>                
                <td>                    
                    <img src="data:image/svg+xml;base64,{{ $qrCodePemohon }}" alt="QR Code" />
                </td>
            </tr>
            <tr>
                <td>Nur Rachmah, S.Hi</td>
                <td></td>
                <td>{{ $pemohon->nama ?? 'N/A' }}</td>
            </tr>
        </table>
            

    </div>
</body>
</html>

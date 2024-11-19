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
           
        </table>
    
        @if ($pemohon->cheklist_ubah_status && !$pemohon->cheklist_ubah_alamat)
        <h4 style="text-align: left; padding-left: 50px;">Detail Perubahan Status:</h4>
            <table class="receipt-table">
                <tr>
                    <td style="text-align: center;">Status Awal</td>
                    <td style="text-align: center;">Status Yang Ingin Diubah</td>
                </tr>
                <tr>
                    <th style="text-align: center;">{{ $pemohon->status_awal ?? 'N/A' }}</th>
                    <th style="text-align: center;">{{ $pemohon->status_baru ?? 'N/A' }}</th>
                </tr>                
            </table>
        @elseif ($pemohon->cheklist_ubah_status && $pemohon->cheklist_ubah_alamat)
        <h4 style="text-align: left; padding-left: 50px;">Detail Perubahan Status:</h4>
            <table class="receipt-table">
                <tr>
                    <td style="text-align: center;">Status Awal</td>
                    <td style="text-align: center;">Status Yang Ingin Diubah</td>
                </tr>
                <tr>
                    <th style="text-align: center;">{{ $pemohon->status_awal ?? 'N/A' }}</th>
                    <th style="text-align: center;">{{ $pemohon->status_baru ?? 'N/A' }}</th>
                </tr>                
            </table>
            <h4 style="text-align: left; padding-left: 50px;">Detail Perubahan Alamat:</h4>
            <table class="receipt-table">
                <tr>
                    <th colspan="2" style="text-align: center;">Alamat Lama</th>
                    <th colspan="2" style="text-align: center;">Alamat Baru</th>                   
                </tr>
                <tr>
                    <td>Jalan Awal:</td>
                    <td>{{ $pemohon->jalan_awal ?? 'N/A' }}</td>
                    <td>Jalan Baru:</td>
                    <td>{{ $pemohon->jalan_baru ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>RT/RW Awal:</td>
                    <td>{{ $pemohon->rt_rw_awal ?? 'N/A' }}</td>
                    <td>RT/RW Baru:</td>
                    <td>{{ $pemohon->rt_rw_baru ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Kel/Des Awal:</td>
                    <td>{{ $pemohon->kel_des_awal ?? 'N/A' }}</td>
                    <td>Kel/Des Baru:</td>
                    <td>{{ $pemohon->kel_des_baru ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Kec Awal:</td>
                    <td>{{ $pemohon->kec_awal ?? 'N/A' }}</td>
                    <td>Kec Baru:</td>
                    <td>{{ $pemohon->kec_baru ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Kab/Kota Awal:</td>
                    <td>{{ $pemohon->kab_kota_awal ?? 'N/A' }}</td>
                    <td>Kab/Kota Baru:</td>
                    <td>{{ $pemohon->kab_kota_baru ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Provinsi Awal :</td>
                    <td>{{ $pemohon->provinsi_awal ?? 'N/A' }}</td>
                    <td>Provinsi Baru:</td>
                    <td>{{ $pemohon->provinsi_baru ?? 'N/A' }}</td>
                </tr>
            </table>   
            @endif
            <br><br>
            <!-- Add space for signature, name, date, and QR code -->
            <table class="receipt-table" style="margin-left: auto; margin-left: 300px;">
                <tr>
                    <!-- Empty columns for the signature and name -->
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <!-- Third column for date and location -->
                    <td style="border: none;">Pemohon,<br>Lhokseumawe, {{ $createdAtFormatted }}</td>
                </tr>
                <tr>
                    <!-- Empty rows for signature area -->
                    <td style="border: none;">&nbsp;</td>
                    <td style="border: none;">&nbsp;</td>
                    <!-- QR code area -->
                    <td style="border: none;">
                        <img src="data:image/svg+xml;base64,{{ $qrCodePemohon }}" alt="QR Code" />
                    </td>
                </tr>
                <tr>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none;">{{ $pemohon->pemohon->nama ?? 'N/A' }}</td>
                </tr>
            </table>
            

    </div>
</body>
</html>

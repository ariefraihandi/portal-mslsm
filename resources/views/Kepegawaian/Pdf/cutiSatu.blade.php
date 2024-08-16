<!DOCTYPE html>
<html>
<head>
    <title>PDF with QR Code</title>
    <style>
         body {
            font-size: 10pt;
            font-family: Arial, sans-serif;
          
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }     
    </style>
</head>
<body>
    <table style="width: 100%; border: none;">
        <tr>
            <td width="250"></td>            
            <td colspan="2" style="text-align: left; margin-top: 20px;">Lhokseumawe, {{ $data['created_at'] }}</td>
        </tr>
        <tr>
            <td width="250"></td>
            <td colspan="2" style="text-align: left;">Yth. Ketua Mahkamah Syar’iyah Lhokseumawe</td>
        </tr>
        <tr>
            <td width="250"></td>
            <td colspan="2" style="text-align: left;">Di</td>
        </tr>
        <tr>
            <td width="250"></td>
            <td width="30"></td>
            <td style="text-align: left;">Lhokseumawe</td>
        </tr>
        <tr>
            <td colspan="3"  style="text-align: center;"><strong><br>FORMULIR PERMINTAAN DAN PEMBERIAN CUTI<br>Nomor:&nbsp;{{ $data['no_surat'] }}</strong></td>
        </tr>
    </table>
  
    <table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
        <tr>
            <td colspan="4"  style="border: 1px solid black;"><strong>&nbsp;I. DATA PEGAWAI</strong></td>
        </tr>
        <tr>
            <td width="12%" style="border: 1px solid black;">&nbsp;Nama</td>
            <td width="38%" style="border: 1px solid black;">&nbsp;{{ $data['name'] }}</td>
            <td width="12%" style="border: 1px solid black;">&nbsp;NIP</td>
            <td width="38%" style="border: 1px solid black;">&nbsp;{{ $data['nip'] }}</td>
        </tr>
        <tr>
            <td width="12%" style="border: 1px solid black;">&nbsp;Jabatan</td>
            <td width="38%" style="border: 1px solid black;">&nbsp;{{ $data['jabatan'] }}</td>
            <td width="12%" style="border: 1px solid black;">&nbsp;Masa Kerja</td>
            <td width="38%" style="border: 1px solid black;">&nbsp;{{ $data['lamaBekerja'] }}</td>
        </tr>
        <tr>
            <td width="12%" style="border: 1px solid black;">&nbsp;Unit Kerja</td>
            <td width="38%" style="border: 1px solid black;">&nbsp;{{ $data['instansi'] }}</td>
            <td width="12%" style="border: 1px solid black;"></td>
            <td width="38%" style="border: 1px solid black;"></td>
        </tr>
    </table>
    <br/>
    <table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
        <tr>
            <td colspan="4" style="border: 1px solid black;"><strong>&nbsp;II. JENIS CUTI YANG DIAMBIL</strong></td>
        </tr>
        <tr>
            <td width="38%" style="border: 1px solid black;">&nbsp;1. Cuti Tahunan</td>
            <td width="12%" style="border: 1px solid black; text-align: center;">
                @if ($data['jenis'] === 'CT')
                    V
                @endif
            </td>
            <td width="38%" style="border: 1px solid black;">&nbsp;2. Cuti Besar</td>
            <td width="12%" style="border: 1px solid black; text-align: center;">
                @if ($data['jenis'] === 'CB')
                    V
                @endif
            </td>
        </tr>
        <tr>
            <td width="38%" style="border: 1px solid black;">&nbsp;3. Cuti Sakit</td>
            <td width="12%" style="border: 1px solid black; text-align: center;">
                @if ($data['jenis'] === 'CS')
                    V
                @endif
            </td>
            <td width="38%" style="border: 1px solid black;">&nbsp;4. Cuti Melahirkan</td>
            <td width="12%" style="border: 1px solid black; text-align: center;">
                @if ($data['jenis'] === 'CM')
                    V
                @endif
            </td>
        </tr>
        <tr>
            <td width="38%" style="border: 1px solid black;">&nbsp;5. Cuti Karena Alasan Penting</td>
            <td width="12%" style="border: 1px solid black; text-align: center;">
                @if ($data['jenis'] === 'CAP')
                    V
                @endif
            </td>
            <td width="38%" style="border: 1px solid black;">&nbsp;6. Cuti di Luar Tanggungan Negara</td>
            <td width="12%" style="border: 1px solid black; text-align: center;"></td>
        </tr>
        
    </table>
    <br/>
    <table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
        <tr>
            <td colspan="4" style="border: 1px solid black;"><strong>&nbsp;III. ALASAN CUTI</strong></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 1px solid black;">&nbsp;{{ $data['alasan']}}</td>
        </tr>
    </table>
    <br/>
    <table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
        <tr>
            <td colspan="6" style="border: 1px solid black;"><strong>&nbsp;IV. LAMANYA CUTI</strong></td>
        </tr>
        <tr>
            <td style="width:12%; border: 1px solid black;">&nbsp;Selama</td>
            <td style="width:26%; border: 1px solid black;">&nbsp;{{ $data['jumlahHariCuti']}}  ( {{ $data['cutiTerbilang']}}  ) Hari Kerja</td>
            <td style="width:16%; border: 1px solid black;">&nbsp;Mulai tanggal</td>
            <td style="width:20%; border: 1px solid black;">&nbsp;{{ $data['tglawal']}}</td>
            <td style="width:6%; border: 1px solid black;">&nbsp;s.d</td>
            <td style="width:20%; border: 1px solid black;">&nbsp;{{ $data['tglakhir']}}</td>
        </tr>
    </table>
    <br/>
    <table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
        <tr>
            <td colspan="5" style="border: 1px solid black;"><strong>&nbsp;V. CATATAN CUTI***</strong></td>
        </tr>
        <tr>
            <td colspan="3" style="width:40%; border: 1px solid black;">&nbsp;1. Cuti Tahunan</td>
            <td style="width:45%; border: 1px solid black;">&nbsp;2. CUTI BESAR</td>
            <td style="width:15%; border: 1px solid black;"></td>
        </tr>
        <tr>
            <td style="width:12%; border: 1px solid black;">&nbsp;Tahun</td>
            <td style="width:12%; border: 1px solid black;">&nbsp;Sisa</td>
            <td style="width:16%; border: 1px solid black;">&nbsp;Keterangan</td>
            <td style="width:45%; border: 1px solid black;">&nbsp;3. CUTI SAKIT</td>
            <td style="width:15%; border: 1px solid black;"></td>
        </tr>
        <tr>
            <td style="width:12%; border: 1px solid black;">&nbsp;N-2</td>
            <td style="width:12%; border: 1px solid black; text-align: center;">{{ $data['cuti_ndua']}}</td>
            <td style="width:16%; border: 1px solid black; text-align: center;"></td>-</td>
            <td style="width:45%; border: 1px solid black;">&nbsp;4. CUTI MELAHIRKAN</td>
            <td style="width:15%; border: 1px solid black;"></td>
        </tr>
        <tr>
            <td style="width:12%; border: 1px solid black;">&nbsp;N-1</td>
            <td style="width:12%; border: 1px solid black; text-align: center;">{{ $data['cuti_nsatu']}}</td>
            <td style="width:12%; border: 1px solid black; text-align: center;">-</td>
            <td style="width:12%; border: 1px solid black;">&nbsp;5. CUTI KARENA ALASAN PENTING</td>
            <td style="width:12%; border: 1px solid black;"></td>
        </tr>
        <tr>
            <td style="width:12%; border: 1px solid black;">&nbsp;N</td>
            <td style="width:12%; border: 1px solid black; text-align: center;">{{ $data['cuti_n']}}</td>
            <td style="width:16%; border: 1px solid black; text-align: center;">-</td>
            <td style="width:45%; border: 1px solid black;">&nbsp;6. CUTI DI LUAR TANGGUNGAN NEGARA</td>
            <td style="width:15%; border: 1px solid black;"></td>
        </tr>
    </table>
    <br/>  
    <table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
        <tr>
            <td colspan="5" style="border: 1px solid black;"><strong>&nbsp;VI. ALAMAT SELAMA MENJALANKAN CUTI</strong></td>
        </tr>
        <tr>
            <td style="width:50%; border: 1px solid black; text-align: left;" rowspan="2" colspan="2">&nbsp;{{ $data['alamat']}}</td>
            <td style="width:10%; border: 1px solid black;">&nbsp;TELP</td>
            <td colspan="2" style="width:40%; border: 1px solid black;">&nbsp;{{ $data['whatsapp']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="width:30%; border: 1px solid black;">&nbsp;Hormat Saya<br><br><em>&nbsp;(e-Sign)</em><br><strong>&nbsp;{{ $data['name'] }}</strong><br><strong>&nbsp;NIP. {{ $data['nip'] }}</strong></td>
            <td style="width:20%; border: 1px solid black; text-align: center;">
                
                <img src="data:image/png;base64, {!! $data['qrCodePegawai'] !!}">
            </td> 
        </tr>
    </table> 
    <br/>
 

    <table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
        <tr>
            <td colspan="5" style="border: 1px solid black;"><strong>&nbsp;VII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI*</strong></td>
        </tr>
        <tr>
            <td style="width:16%; border: 1px solid black;">&nbsp;DISETUJUI</td>
            <td style="width:16%; border: 1px solid black;">&nbsp;PERUBAHAN</td>
            <td style="width:18%; border: 1px solid black;">&nbsp;DITANGGUHKAN</td>
            <td colspan="2" style="width:50%; border: 1px solid black;">&nbsp;TIDAK DISETUJUI</td>       
        </tr>
        <tr>
            <td style="width:16%; border: 1px solid black; text-align: center;">
                @if ($data['status'] === '10')
                    V
                @endif
            </td>
            <td style="width:16%; border: 1px solid black; text-align: center;"></td>
            <td style="width:18%; border: 1px solid black; text-align: center;"></td>
            <td colspan="2" style="width:50%; border: 1px solid black; text-align: center;"></td>
        </tr>
        <tr>
            <td colspan="3" style="border: 1px solid black width:50%;"></td>            
            <td style="border: 1px solid black; width:30%;">&nbsp;{{ $data['jabatanpim'] }},<br><br><em>&nbsp;(e-Sign)</em><br><strong>&nbsp;{{ $data['namepim'] }}</strong><br><strong>&nbsp;NIP. {{ $data['nippim'] }}</strong></td>
            <td style="width:20%; border: 1px solid black; text-align: center;">
                
                <img src="data:image/png;base64, {!! $data['qrCodePejabat'] !!}">
            </td> 
        </tr>
    </table> 
</body>
</html>

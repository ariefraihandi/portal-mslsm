<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pekerjaan = [
            ['nama_pekerjaan' => 'Akuntan'],
            ['nama_pekerjaan' => 'Anggota BPK'],
            ['nama_pekerjaan' => 'Anggota DPD'],
            ['nama_pekerjaan' => 'Anggota DPR RI'],
            ['nama_pekerjaan' => 'Anggota DPRD Kab/Kota'],
            ['nama_pekerjaan' => 'Anggota DPRD Propinsi'],
            ['nama_pekerjaan' => 'Anggota Kabinet /Kementerian'],
            ['nama_pekerjaan' => 'Anggota Mahkamah Konstitusi'],
            ['nama_pekerjaan' => 'Apoteker'],
            ['nama_pekerjaan' => 'Arsitek'],
            ['nama_pekerjaan' => 'Belum/tidak bekerja'],
            ['nama_pekerjaan' => 'Biarawati'],
            ['nama_pekerjaan' => 'Bidan'],
            ['nama_pekerjaan' => 'Bupati'],
            ['nama_pekerjaan' => 'Buruh harian lepas'],
            ['nama_pekerjaan' => 'Buruh nelayan / perikanan'],
            ['nama_pekerjaan' => 'Buruh peternakan'],
            ['nama_pekerjaan' => 'Buruh tani / perkebunan'],
            ['nama_pekerjaan' => 'Dokter'],
            ['nama_pekerjaan' => 'Dosen'],
            ['nama_pekerjaan' => 'Duta Besar'],
            ['nama_pekerjaan' => 'Gubernur'],
            ['nama_pekerjaan' => 'Guru'],
            ['nama_pekerjaan' => 'Imam masjid'],
            ['nama_pekerjaan' => 'Industri'],
            ['nama_pekerjaan' => 'Juru masak'],
            ['nama_pekerjaan' => 'Karyawan BUMD'],
            ['nama_pekerjaan' => 'Karyawan BUMN'],
            ['nama_pekerjaan' => 'Karyawan Honorer'],
            ['nama_pekerjaan' => 'Karyawan swasta'],
            ['nama_pekerjaan' => 'Kepala Desa'],
            ['nama_pekerjaan' => 'Kepolisian RI'],
            ['nama_pekerjaan' => 'Konstruksi'],
            ['nama_pekerjaan' => 'Konsultan'],
            ['nama_pekerjaan' => 'Lainnya'],
            ['nama_pekerjaan' => 'Mekanik'],
            ['nama_pekerjaan' => 'Mengurus rumah tangga'],
            ['nama_pekerjaan' => 'Nelayan/perikanan'],
            ['nama_pekerjaan' => 'Notaris'],
            ['nama_pekerjaan' => 'Paraji'],
            ['nama_pekerjaan' => 'Paranormal'],
            ['nama_pekerjaan' => 'Pastur'],
            ['nama_pekerjaan' => 'Pedagang'],
            ['nama_pekerjaan' => 'Pegawai Negeri Sipil'],
            ['nama_pekerjaan' => 'Pelajar/Mahasiswa'],
            ['nama_pekerjaan' => 'Pelaut'],
            ['nama_pekerjaan' => 'Pembantu rumah tangga'],
            ['nama_pekerjaan' => 'Penata busana'],
            ['nama_pekerjaan' => 'Penata rambut'],
            ['nama_pekerjaan' => 'Penata rias'],
            ['nama_pekerjaan' => 'Pendeta'],
            ['nama_pekerjaan' => 'Peneliti'],
            ['nama_pekerjaan' => 'Pengacara'],
            ['nama_pekerjaan' => 'Pensiun'],
            ['nama_pekerjaan' => 'Penterjemah'],
            ['nama_pekerjaan' => 'Penyiar radio'],
            ['nama_pekerjaan' => 'Penyiar televisi'],
            ['nama_pekerjaan' => 'Perancang busana'],
            ['nama_pekerjaan' => 'Perangkat Desa'],
            ['nama_pekerjaan' => 'Perawat'],
            ['nama_pekerjaan' => 'Perdagangan'],
            ['nama_pekerjaan' => 'Petani/pekebun'],
            ['nama_pekerjaan' => 'Peternak'],
            ['nama_pekerjaan' => 'Pialang'],
            ['nama_pekerjaan' => 'Pilot'],
            ['nama_pekerjaan' => 'Presiden'],
            ['nama_pekerjaan' => 'Promotor acara'],
            ['nama_pekerjaan' => 'Psikiater/psikolog'],
            ['nama_pekerjaan' => 'Seniman'],
            ['nama_pekerjaan' => 'Sopir'],
            ['nama_pekerjaan' => 'Tabib'],
            ['nama_pekerjaan' => 'Tentara Nasional Indonesia'],
            ['nama_pekerjaan' => 'Transportasi'],
            ['nama_pekerjaan' => 'Tukang jahit'],
            ['nama_pekerjaan' => 'Tukang batu'],
            ['nama_pekerjaan' => 'Tukang cukur'],
            ['nama_pekerjaan' => 'Tukang gigi'],
            ['nama_pekerjaan' => 'Tukang kayu'],
            ['nama_pekerjaan' => 'Tukang las/pandai besi'],
            ['nama_pekerjaan' => 'Tukang listrik'],
            ['nama_pekerjaan' => 'Tukang sol sepatu'],
            ['nama_pekerjaan' => 'Ustadz/muballigh'],
            ['nama_pekerjaan' => 'Wakil Bupati'],
            ['nama_pekerjaan' => 'Wakil Gubernur'],
            ['nama_pekerjaan' => 'Wakil Presiden'],
            ['nama_pekerjaan' => 'Wakil Walikota'],
            ['nama_pekerjaan' => 'Walikota'],
            ['nama_pekerjaan' => 'Wartawan']
        ];

        DB::table('pekerjaan')->insert($pekerjaan);
    }
}

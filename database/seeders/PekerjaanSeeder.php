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
        // Nonaktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the table to remove all existing data
        DB::table('pekerjaan')->truncate();

        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Define the pekerjaan data
        $pekerjaans = [
            'Belum/tidak bekerja',
            'Mengurus rumah tangga',
            'Pelajar/Mahasiswa',
            'Pensiun',
            'Pegawai Negeri Sipil',
            'Tentara Nasional Indonesia',
            'Kepolisian RI',
            'Perdagangan',
            'Petani/pekebun',
            'Peternak',
            'Nelayan/perikanan',
            'Industri',
            'Konstruksi',
            'Transportasi',
            'Karyawan swasta',
            'Karyawan BUMN',
            'Karyawan BUMD',
            'Karyawan Honorer',
            'Buruh harian lepas',
            'Buruh nelayan / perikanan',
            'Buruh peternakan',
            'Buruh tani / perkebunan',
            'Pembantu rumah tangga',
            'Tukang batu',
            'Tukang cukur',
            'Tukang kayu',
            'Tukang listrik',
            'Tukang las/pandai besi',
            'Tukang sol sepatu',
            'Mekanik',
            'Penata busana',
            'Penata rambut',
            'Penata rias',
            'Paraji',
            'Tabib',
            'Seniman',
            'Perancang busana',
            'Penterjemah',
            'Imam masjid',
            'Pastur',
            'Pendeta',
            'Ustadz/muballigh',
            'Anggota DPR RI',
            'Anggota DPD',
            'Anggota BPK',
            'Presiden',
            'Wakil Presiden',
            'Anggota Kabinet /Kementerian',
            'Duta Besar',
            'Gubernur',
            'Wakil Gubernur',
            'Bupati',
            'Wakil Bupati',
            'Walikota',
            'Wakil Walikota',
            'Anggota DPRD Propinsi',
            'Anggota DPRD Kab/Kota',
            'Dosen',
            'Guru',
            'Pilot',
            'Pengacara',
            'Notaris',
            'Arsitek',
            'Akuntan',
            'Konsultan',
            'Dokter',
            'Bidan',
            'Perawat',
            'Apoteker',
            'Psikiater/psikolog',
            'Penyiar radio',
            'Penyiar televisi',
            'Promotor acara',
            'Sopir',
            'Wartawan',
            'Peneliti',
            'Pialang',
            'Paranormal',
            'Biarawati',
            'Anggota Mahkamah Konstitusi',
            'Perangkat Desa',
            'Kepala Desa',
            'Lainnya'
        ];

        foreach ($pekerjaans as $pekerjaan) {
            DB::table('pekerjaan')->insert([
                'nama_pekerjaan' => $pekerjaan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

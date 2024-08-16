<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate the table to remove all existing data
        DB::table('jabatan')->truncate();

        $jabatans = [
            'Ketua',
            'Wakil Ketua',
            'Panitera',
            'Sekretaris',
            'Hakim',
            'Panitera Muda Hukum',
            'Panitera Muda Gugatan',
            'Panitera Muda Permohonan',
            'Panitera Muda Jinayat',
            'Panitera Pengganti',
            'Kasubbag Umum dan Keuangan',
            'Kasubbag Perencanaan, TI dan Pelaporan',
            'Kasubbag Kepegawaian dan Ortala',
            'Analis Pengelolaan Keuangan APBN Ahli Muda',
            'Juru Sita',
            'Juru Sita Pengganti',
            'Pranata Komputer Ahli Pertama',
            'Analis Perkara Peradilan',
            'Pengolah Data dan Informasi',
            'Arsiparis Terampil',
            'Calon Hakim',
            'CPNS',
            'PPNPN',
            'Magang'
        ];

        foreach ($jabatans as $jabatan) {
            DB::table('jabatan')->insert([
                'name' => $jabatan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

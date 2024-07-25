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
            'Kasubbag Keuangan / Umum',
            'Kasubbag Perencanaan / IT',
            'Kasubbag Kepegawaian',
            'Juru Sita',
            'Juru Sita Pengganti',
            'Pranata Komputer Ahli Pertama',
            'Analis Perkara Peradilan',
            'Pengelola Barang Milik Negara',
            'Arsiparis Pelaksana',
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

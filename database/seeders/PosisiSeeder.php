<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posisis = [
            'Hakim',
            'Pegawai',
            'CAKIM',
            'CPNS',
            'PPNPN',
            'Magang'
        ];

        foreach ($posisis as $posisi) {
            DB::table('posisi')->insert([
                'name' => $posisi,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

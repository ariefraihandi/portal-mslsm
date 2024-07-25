<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CutiSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cuti')->insert([
            ['name' => 'Cuti Tahunan', 'code' => 'CT', 'jumlah' => 12],
            ['name' => 'Cuti Sakit', 'code' => 'CS', 'jumlah' => 14],
            ['name' => 'Cuti Alasan Penting', 'code' => 'CAP', 'jumlah' => 10],
            ['name' => 'Cuti Besar', 'code' => 'CB', 'jumlah' => 90],
            ['name' => 'Cuti Melahirkan', 'code' => 'CM', 'jumlah' => 90],
        ]);
    }
}

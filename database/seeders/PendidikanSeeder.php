<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendidikanSeeder extends Seeder
{
    public function run()
    {
        $pendidikan = [
            ['name' => 'Tidak Sekolah'],
            ['name' => 'Sekolah Dasar (Sederajat)'],
            ['name' => 'Sekolah Menengah Pertama (Sederajat)'],
            ['name' => 'Sekolah Menengah Atas / Sekolah Menengah Kejuruan (Sederajat)'],
            ['name' => 'Akademi/Diploma'],
            ['name' => 'Diploma IV/Strata I'],
            ['name' => 'Strata II'],
            ['name' => 'Strata III'],
        ];

        DB::table('pendidikan')->insert($pendidikan);
    }
}

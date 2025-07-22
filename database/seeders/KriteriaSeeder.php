<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('kriteria')->insert([
            [
                'kode' => 'C1',
                'nama_kriteria' => 'Okupasi',
                'bobot' => 0.4,
                'tipe' => 'cost',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'C2',
                'nama_kriteria' => 'Wicara',
                'bobot' => 0.3,
                'tipe' => 'benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'C3',
                'nama_kriteria' => 'Fisioterapi',
                'bobot' => 0.3,
                'tipe' => 'benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

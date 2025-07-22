<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SubKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/sub_kriteria_seeder_data.json');

        // Cek apakah file JSON ada
        if (!File::exists($jsonPath)) {
            $this->command->error("File tidak ditemukan: $jsonPath");
            return;
        }

        $data = json_decode(File::get($jsonPath), true);

        foreach ($data as $item) {
            $kriteria = DB::table('kriterias')
                ->where('nama_kriteria', $item['kriteria'])
                ->first();

            if (!$kriteria) {
                Log::warning("Kriteria tidak ditemukan: " . $item['kriteria']);
                continue;
            }

            DB::table('sub_kriterias')->insert([
                'kriteria_id' => $kriteria->id,
                'nama_sub_kriteria' => $item['nama_sub_kriteria'],
                'nilai' => $item['nilai'],
                'rentang_usia' => $item['rentang_usia'],
                'tahapan' => $item['tahapan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info("SubKriteriaSeeder berhasil dijalankan.");
    }
}

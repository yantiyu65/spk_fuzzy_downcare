<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('perkembangan_anaks', function (Blueprint $table) {
            $table->float('nilai_z')->nullable(); // hasil defuzzifikasi
            $table->string('kategori')->nullable(); // kategori tunagrahita (Rendah/Sedang/Berat)
            $table->text('rekomendasi')->nullable(); // rekomendasi terapi
        });
    }
    
    public function down()
    {
        Schema::table('perkembangan_anaks', function (Blueprint $table) {
            $table->dropColumn(['nilai_z', 'kategori', 'rekomendasi']);
        });
    }
    
};

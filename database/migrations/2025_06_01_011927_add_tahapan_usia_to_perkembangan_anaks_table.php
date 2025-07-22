<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('perkembangan_anaks', function (Blueprint $table) {
            $table->string('tahapan_usia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perkembangan_anaks', function (Blueprint $table) {
             $table->dropColumn('tahapan_usia');
        });
    }
};

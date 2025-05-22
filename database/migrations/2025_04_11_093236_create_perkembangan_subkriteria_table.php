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
        Schema::create('perkembangan_subkriteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perkembangan_anak_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_kriteria_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perkembangan_subkriteria');
    }
};

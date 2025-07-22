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
         Schema::table('sub_kriterias', function (Blueprint $table) {
        $table->text('tahapan')->change();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('sub_kriterias', function (Blueprint $table) {
        $table->string('tahapan', 255)->change(); // atau panjang default sebelumnya
    });
    }
};

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
        Schema::create('perkembangan_anaks', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // relasi ke tabel users
        $table->string('nama_anak');
        $table->integer('usia'); // 
        $table->string('jenis_kelamin');
        $table->tinyInteger('okupasi')->nullable(); // nilai 1 - 5
        $table->tinyInteger('wicara')->nullable();   // nilai 1 - 5
        $table->tinyInteger('fisioterapi')->nullable(); // nilai 1 - 5
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perkembangan_anaks');
    }
};

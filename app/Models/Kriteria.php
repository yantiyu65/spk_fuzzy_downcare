<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kriteria extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'nama_kriteria', 'bobot', 'tipe'];

    public function subKriterias()
    {
        return $this->hasMany(SubKriteria::class);
    }
}

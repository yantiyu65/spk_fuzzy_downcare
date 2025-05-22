<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubKriteria extends Model
{
    use HasFactory;

    protected $fillable = ['kriteria_id', 'nama_sub_kriteria', 'nilai'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
    public function perkembanganAnaks()
    {
    return $this->belongsToMany(PerkembanganAnak::class, 'perkembangan_subkriteria', 'sub_kriteria_id', 'perkembangan_anak_id');
    }
}

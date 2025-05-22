<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerkembanganAnak extends Model
{
    use HasFactory;

    protected $fillable = ['nama_anak',
    'usia',
    'jenis_kelamin',
    'okupasi',
    'wicara',
    'fisioterapi',
    'user_id',
    'nilai_z',
    'kategori',
    'rekomendasi',
    'tanggal'];

    public function subkriterias()
    {
        return $this->belongsToMany(SubKriteria::class, 'perkembangan_subkriteria', 'perkembangan_anak_id', 'sub_kriteria_id');
    }

}

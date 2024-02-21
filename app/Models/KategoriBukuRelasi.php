<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bukubuku; // Impor model Bukubuku
use App\Models\KategoriBuku; // Impor model KategoriBuku

class KategoriBukuRelasi extends Model
{
    protected $table = 'kategoribuku_relasi';
    protected $primaryKey = 'kategoribukuid';

    protected $fillable = ['bukuid', 'kategoriid'];

    public function bukubuku()
    {
        return $this->belongsTo(Bukubuku::class, 'bukuid');
    }

    public function kategoriBuku()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategoriid');
    }
}


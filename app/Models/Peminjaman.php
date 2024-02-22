<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bukubuku; // Impor model Bukubuku
use App\Models\User; // Impor model User

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'peminjamanid';


    public function bukubuku()
    {
        return $this->belongsTo(Bukubuku::class, 'bukuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}

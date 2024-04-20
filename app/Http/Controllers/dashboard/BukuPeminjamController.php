<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bukubuku;
use App\Models\Peminjaman;
use App\Models\KategoriBuku;
use App\Models\KategoriBukuRelasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class BukuPeminjamController extends Controller
{
    public function index(Request $request, Bukubuku $bukubuku)
    {
        $q = $request->input('q');

        $active = 'Buku';

        $bukubuku = $bukubuku->when($q, function($query) use ($q) {
                return $query->where('title', 'like', '%' .$q. '%')
                             ->orwhere('description', 'like', '%' .$q. '%');
            })

        ->paginate(10);
        return view('dashboard/bukupeminjam/list', [
            'bukubuku' => $bukubuku,
            'request' => $request,
            'active' => $active
        ]);
    }
    public function pinjam($bukuid)
    {
        // Dapatkan informasi pengguna yang sedang masuk
        $iduser = auth()->id();
        
        // Simpan data peminjaman ke dalam tabel peminjaman
        
        Peminjaman::create([
            'id' => $iduser,
            'bukuid' => $bukuid,
            'tanggalpeminjaman' => now(), // Tanggal peminjaman saat ini
            'status_peminjaman' => 'Belum Dikembalikan', // Atur status peminjaman sesuai kebutuhan
        ]);
    
        // Redirect pengguna kembali ke halaman buku dengan pesan sukses
        return redirect()->route('dashboard.bukupeminjam')->with('message', 'Buku berhasil dipinjam silahkan buka menu PEMINJAMAN.');
    }
}

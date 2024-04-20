<?php

namespace App\Http\Controllers\dashboard;

use App\Models\User;
use Carbon\Carbon;  
use App\Models\Bukubuku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Peminjaman $peminjaman)
    {
        // Mendapatkan level akun pengguna saat ini
    $userLevel = auth()->user()->level; // Ini adalah contoh, sesuaikan dengan struktur data Anda
    $q = $request->input('q');
    
    $user = Auth::user(); // Mendapatkan informasi user yang sedang login

    $active = 'Peminjaman';

    $peminjaman = $peminjaman
        ->when($userLevel != 1 && $userLevel != 2, function ($query) use ($user) {
            // Menambahkan filter berdasarkan ID user yang sedang login jika bukan level 1 atau 2
            return $query->where('id', $user->id);
        })
        ->when($q, function($query) use ($q) {
            return $query->where('id', 'like', '%' . $q . '%')
                ->orWhereHas('bukubuku', function($subquery) use ($q) {
                    $subquery->where('title', 'like', '%' . $q . '%');
                });
        })
        ->with('bukubuku') // Memuat relasi 'buku'
        ->paginate(10);

    return view('dashboard/peminjaman/list', [
        'peminjaman' => $peminjaman,
        'request' => $request,
        'active' => $active,
        'level' => $userLevel
    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all(); // Ambil semua data buku yang diperlukan
        $bukubuku = Bukubuku::all(); // Jika diperlukan, ambil juga data buku
        $active = 'Peminjaman';
        return view('dashboard/peminjaman/form', [
            'user' => $user,
            'bukubuku' => $bukubuku,
            'active' => $active,
            'button' =>'Create',
            'url'    =>'dashboard.peminjaman.store'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'                    => 'required',
            'bukuid'                => 'required|unique:App\Models\Peminjaman,bukuid',
            'tanggalpeminjaman'     => 'required',
            'tanggalpengembalian'   => 'required',
            'status_peminjaman'     => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.peminjaman.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $pinjam = new Peminjaman(); 
            $pinjam->id = $request->input('id');
            $pinjam->bukuid = $request->input('bukuid');
            $pinjam->tanggalpeminjaman = $request->input('tanggalpeminjaman'); 
            $pinjam->tanggalpengembalian = $request->input('tanggalpengembalian');
            $pinjam->status_peminjaman = $request->input('status_peminjaman');
            $pinjam->save();
    
            return redirect()
                ->route('dashboard.peminjaman')
                ->with('message', __('message.store', ['pinjam'=>$request->input('pinjam')]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function show(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function edit(Peminjaman $pinjam)
    {
        $bukubuku = Bukubuku::all(); // Ambil semua data buku
        $user = User::all(); // Ambil semua data kategori User
        $active = 'Peminjaman';
        return view('dashboard/peminjaman/form', [
            'active' => $active,
            'pinjam' => $pinjam,
            'bukubuku'   => $bukubuku,
            'user' => $user,
            'button' =>'Update',        
            'url'    =>'dashboard.peminjaman.update'
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peminjaman $pinjam)
    {
        $validator = Validator::make($request->all(), [
            'id'                    => 'required',
            'bukuid'                => 'required',
            'tanggalpeminjaman'     => 'required',
            'tanggalpengembalian'   => 'required',
            'status_peminjaman'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.peminjaman.update', $pinjam->peminjamanid)
                ->withErrors($validator)
                ->withInput();
        } else {
            
            // Menghitung selisih hari antara tanggal pengembalian aktual dan tanggal pengembalian yang diharapkan
            $tanggalPengembalianAktual = Carbon::parse($request->tanggalpengembalian);
            $tanggalPengembalianHarapkan = Carbon::parse($pinjam->tanggalpengembalian);
            $selisihHari = $tanggalPengembalianAktual->diffInDays($tanggalPengembalianHarapkan);

            // Menghitung denda jika lebih dari 5 hari
            $denda = ($selisihHari > 5) ? ($selisihHari - 5) * 1000 : 0;
            
            $pinjam->id = $request->input('id');
            $pinjam->bukuid = $request->input('bukuid');
            $pinjam->tanggalpeminjaman = $request->input('tanggalpeminjaman'); 
            $pinjam->tanggalpengembalian = $request->input('tanggalpengembalian');
            $pinjam->status_peminjaman = $request->input('status_peminjaman');
            $pinjam->denda = $denda;
            $pinjam ->save();

            return redirect()
                        ->route('dashboard.peminjaman')
                        ->with('message', __('message.update', ['pinjam'=>$request->input('pinjam')]));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */

     
     public function kembalikan($peminjamanid)
     {
         $peminjaman = Peminjaman::find($peminjamanid);
 
         if (!$peminjaman) {
             return redirect()->route('dashboard.peminjaman')->with('error', 'Peminjaman tidak ditemukan.');
         }
 
         // Lakukan logika pengembalian di sini, misalnya mengubah status peminjaman menjadi "Sudah kembali"
         $peminjaman->tanggalpengembalian = now();
         $peminjaman->status_peminjaman = 'Sudah kembali';
         $peminjaman->save();
 
         return redirect()->route('dashboard.peminjaman')->with('success', 'Peminjaman berhasil dikembalikan.');
     }

    public function destroy(Peminjaman $pinjam)
    {
        $id = $pinjam->id;

        $pinjam->delete();
        return redirect()
                ->route('dashboard.peminjaman')
                ->with('message', __('message.delete', ['pinjam' => $pinjam]));
    }
}

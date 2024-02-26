<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Bukubuku;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;  
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;


class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Peminjaman $peminjaman)
    {
        $q = $request->input('q');

        $active = 'Peminjaman';

                $peminjaman = $peminjaman->when($q, function($query) use ($q) {
                    return $query->where('id', 'like', '%' .$q. '%')
                    ->orWhereHas('bukubuku', function($subquery) use ($q) {
                        $subquery->where('title', 'like', '%' . $q . '%');
                    });
                })
                ->with('bukubuku') // Memuat relasi 'buku'

        
        ->paginate(10);
        return view('dashboard/peminjaman/list', [
            'peminjaman' => $peminjaman,
            'request' => $request,
            'active' => $active
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
    public function destroy(Peminjaman $pinjam)
    {
        $id = $pinjam->id;

        $pinjam->delete();
        return redirect()
                ->route('dashboard.peminjaman')
                ->with('message', __('message.delete', ['pinjam' => $pinjam]));
    }
}

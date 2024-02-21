<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\KategoriBukuRelasi;
use App\Models\Bukubuku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class KategoriBukuRelasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, KategoriBukuRelasi $kategoribukurelasi)
    {
        $q = $request->input('q');

        $active = 'Kategori Buku Relasi';

        $kategoribukurelasi = $kategoribukurelasi->when($q, function($query) use ($q) {
                    return $query->where('bukuid', 'like', '%' .$q. '%');
                })
        
        ->paginate(10);
        return view('dashboard/kategoribukurelasi/list', [
            'kategoribukurelasi' => $kategoribukurelasi,
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
        $bukubuku = Bukubuku::all(); // Ambil semua data buku yang diperlukan
        $kategoriBuku = KategoriBuku::all(); // Jika diperlukan, ambil juga data kategori buku
        $active = 'Kategori Buku Relasi';
        return view('dashboard/kategoribukurelasi/form', [
            'bukubuku' => $bukubuku,
            'kategoriBuku' => $kategoriBuku,
            'active' => $active,
            'button' =>'Create',
            'url'    =>'dashboard.kategoribukurelasi.store'
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
            'bukuid'         => 'required',
            'kategoriid'   => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.kategoribukurelasi.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $kategoribukurelasi = new KategoriBukuRelasi(); //Tambahkan ini untuk membuat objek KategoriBukuRelasi
            $kategoribukurelasi->bukuid = $request->input('bukuid');
            $kategoribukurelasi->kategoriid = $request->input('kategoriid');
            $kategoribukurelasi->save();
    
            return redirect()
                ->route('dashboard.kategoribukurelasi')
                ->with('message', __('message.store', ['title'=>$request->input('title')]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Models\KategoriBukuRelasi  $kategoriBukuRelasi
     * @return \Illuminate\Http\Response
     */
    public function show(KategoriBukuRelasi $kategoriBukuRelasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Models\KategoriBukuRelasi  $kategoriBukuRelasi
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoriBukuRelasi $kategoriBukuRelasi)
    {
        $bukubuku = Bukubuku::all(); // Ambil semua data buku
        $kategoriBuku = KategoriBuku::all(); // Ambil semua data kategori buku
        $active = 'Kategori Buku Relasi';
        return view('dashboard/kategoriBukuRelasi/form', [
            'active' => $active,
            'kategoriBukuRelasi' => $kategoriBukuRelasi,
            'bukubuku'   => $bukubuku,
            'kategoriBuku' => $kategoriBuku,
            'button' =>'Update',        
            'url'    =>'dashboard.kategoribukurelasi.update'
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Models\KategoriBukuRelasi  $kategoriBukuRelasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KategoriBukuRelasi $kategoriBukuRelasi)
    {
        $validator = Validator::make($request->all(), [
            'bukuid'         => 'required',
            'kategoriid'   => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.kategoribukurelasi.update', $kategoriBukuRelasi->kategoribukuid)
                ->withErrors($validator)
                ->withInput();
        } else {
            $kategoriBukuRelasi->bukuid = $request->input('bukuid');
            $kategoriBukuRelasi->kategoriid = $request->input('kategoriid');
            $kategoriBukuRelasi->save();

            return redirect()
                        ->route('dashboard.kategoribukurelasi')
                        ->with('message', __('message.update', ['bukuid'=>$request->input('bukuid')]));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Models\KategoriBukuRelasi  $kategoriBukuRelasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(KategoriBukuRelasi $kategoriBukuRelasi)
    {
        $kategoribukuid = $kategoriBukuRelasi->kategoribukuid;

        $kategoriBukuRelasi->delete();
        return redirect()
                ->route('dashboard.kategoribukurelasi')
                ->with('message', __('message.delete'));
    }
}

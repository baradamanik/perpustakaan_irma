<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\KoleksiPribadi;
use App\Models\Bukubuku;
use App\Models\User;
use Illuminate\Http\Request;

class KoleksiPribadiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = $request->input('q');

        $active = 'Koleksi Pribadi';

        $koleksipribadi = $koleksipribadi->when($q, function($query) use ($q) {
                    return $query->where('bukuid', 'like', '%' .$q. '%');
                })
        
        ->paginate(10);
        return view('dashboard/kategoribukurelasi/list', [
            'koleksipribadi' => $koleksipribadi,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KoleksiPribadi  $koleksiPribadi
     * @return \Illuminate\Http\Response
     */
    public function show(KoleksiPribadi $koleksiPribadi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KoleksiPribadi  $koleksiPribadi
     * @return \Illuminate\Http\Response
     */
    public function edit(KoleksiPribadi $koleksiPribadi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KoleksiPribadi  $koleksiPribadi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KoleksiPribadi $koleksiPribadi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KoleksiPribadi  $koleksiPribadi
     * @return \Illuminate\Http\Response
     */
    public function destroy(KoleksiPribadi $koleksiPribadi)
    {
        //
    }
}

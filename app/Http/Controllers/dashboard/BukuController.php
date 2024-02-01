<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bukubuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Bukubuku $bukubuku)
    {
        $q = $request->input('q');

        $active = 'Buku';

        $bukubuku = $bukubuku->when($q, function($query) use ($q) {
                return $query->where('title', 'like', '%' .$q. '%')
                             ->orwhere('description', 'like', '%' .$q. '%');
            })

        ->paginate(10);
        return view('dashboard/buku/list', [
            'bukubuku' => $bukubuku,
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
        $active = 'Buku';
        return view('dashboard/buku/form', [
            'active' => $active,
            'button' =>'Create',
            'url'    =>'dashboard.books.store'
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
            'title'         => 'required|unique:App\Models\Bukubuku,title',
            'description'   => 'required',
            'thumbnail'     => 'required|image',
            'penulis'       => 'required',
            'penerbit'      => 'required',
            'tahun_terbit'  => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.books.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $bukubuku = new Bukubuku(); //Tambahkan ini untuk membuat objek Buku
            $image = $request->file('thumbnail');
            $filename = time() . '.' .$image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/buku', $image, $filename);

            $bukubuku->title = $request->input('title');
            $bukubuku->description = $request->input('description');
            $bukubuku->thumbnail = $filename; //Ganti dengan nama file yang baru diupload
            $bukubuku->penulis = $request->input('penulis');
            $bukubuku->penerbit = $request->input('penerbit');
            $bukubuku->tahun_terbit = $request->input('tahun_terbit');
            $bukubuku->save();

            return redirect()->route('dashboard.books');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bukubuku  $bukubuku
     * @return \Illuminate\Http\Response
     */
    public function show(Bukubuku $bukubuku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bukubuku  $bukubuku
     * @return \Illuminate\Http\Response
     */
    public function edit(Bukubuku $bukubuku)
    {
        //
        $active = 'Buku';
        return view('dashboard/buku/form', [
            'active' => $active,
            'buku'   => $bukubuku,
            'button' =>'Update',        
            'url'    =>'dashboard.books.update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bukubuku  $bukubuku
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bukubuku $bukubuku)
    {
        //
        $validator = Validator::make($request->all(), [
            'title'         => 'required|unique:App\Models\Bukubuku,title,'.$bukubuku->bukuid,
            'description'   => 'required',
            'thumbnail'     => 'image',
            'penulis'       => 'required',
            'penerbit'      => 'required',
            'tahun_terbit'  => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.books.update', $bukubuku->bukuid)
                ->withErrors($validator)
                ->withInput();
        } else {
            //$buku = new Buku(); //Tambahkan ini untuk membuat objek Buku
            if($request->hasFile('thumbnail')){
                $image = $request->file('thumbnail');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                    Storage::disk('local')->putFileAs('public/buku', $image, $filename);
                $bukubuku->thumbnail = $filename; //Ganti dengan nama file yang baru diupload
            }
            $bukubuku->title = $request->input('title');
            $bukubuku->description = $request->input('description');
            $bukubuku->penulis = $request->input('penulis');
            $bukubuku->penerbit = $request->input('penerbit');
            $bukubuku->tahun_terbit = $request->input('tahun_terbit');
            $bukubuku->save();

            return redirect()->route('dashboard.books');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bukubuku  $bukubuku
     * @return \Illuminate\Http\Response
     */
    public function destroy(bukubuku $bukubuku)
    {
        //
        $buku->delete();
        return redirect()
                ->route('dashboard.books');
    }
}

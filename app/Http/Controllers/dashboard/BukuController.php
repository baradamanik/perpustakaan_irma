<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bukubuku;
use App\Models\KategoriBuku;
use App\Models\KategoriBukuRelasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

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
        $kategoriBuku = KategoriBuku::all();
        return view('dashboard/buku/form', [
            'kategoriBuku' => $kategoriBuku,
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
            'kategoriid'   => 'required',
            'thumbnail'     => 'required|image',
            'pdf'           => 'required|mimes:pdf', // Hanya izinkan file dengan ekstensi .pdf dan wajib diunggah
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
            //Simpan data Buku
            $bukubuku = new Bukubuku(); //Tambahkan ini untuk membuat objek Buku
            $image = $request->file('thumbnail');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/buku', $image, $filename);
            $bukubuku->title = $request->input('title');
            $bukubuku->kategoriid = $request->input('kategoriid');
            $bukubuku->description = $request->input('description');
            $bukubuku->thumbnail = $filename; //Ganti dengan nama file yang baru diupload
            $bukubuku->penulis = $request->input('penulis');
            $bukubuku->penerbit = $request->input('penerbit');
            $bukubuku->tahun_terbit = $request->input('tahun_terbit');
            $pdf = $request->file('pdf');
            $pdfFileName = time() . '.' . $pdf->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/pdf', $pdf, $pdfFileName);
            $bukubuku->pdf = $pdfFileName; // Simpan nama file PDF ke dalam atribut 'pdf'
            $bukubuku->save();

            // Simpan relasi ke tabel kategoribuku_relasi
            $kategoribuku = new KategoriBukuRelasi();
            $kategoribuku->bukuid = $bukubuku->bukuid; // Menyimpan id buku yang baru saja disimpan
            $kategoribuku->kategoriid = $request->input('kategoriid'); // Menyimpan id kategori yang diberikan
            $kategoribuku->save();
            
            return redirect()
                ->route('dashboard.books')
                ->with('message', __('message.book.store', ['title' => $request->input('title')]));
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
        $kategoriBuku = KategoriBuku::all(); // Ambil semua data kategori buku
        $active = 'Buku';
        return view('dashboard/buku/form', [
            'active' => $active,
            'buku'   => $bukubuku,
            'kategoriBuku' => $kategoriBuku,
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
        $validator = Validator::make($request->all(), [
            'title'         => 'required|unique:App\Models\Bukubuku,title,'.$bukubuku->bukuid,
            'kategoriid'   => 'required',
            'description'   => 'required',
            'thumbnail'     => 'image',
            'pdf'           => 'mimes:pdf', // Hanya izinkan file dengan ekstensi .pdf
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
            if ($request->hasFile('thumbnail')) {
                $image = $request->file('thumbnail');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('local')->putFileAs('public/buku', $image, $filename);
                $bukubuku->thumbnail = $filename; // Ganti dengan nama file yang baru diupload
            }

            if ($request->hasFile('pdf')) {
                $pdf = $request->file('pdf');
                $pdfFileName = time() . '.' . $pdf->getClientOriginalExtension();
                Storage::disk('local')->putFileAs('public/pdf', $pdf, $pdfFileName);
                $bukubuku->pdf = $pdfFileName; // Timpa file PDF lama dengan yang baru
            }

            $bukubuku->title = $request->input('title');
            $bukubuku->kategoriid = $request->input('kategoriid');
            $bukubuku->description = $request->input('description');
            $bukubuku->penulis = $request->input('penulis');
            $bukubuku->penerbit = $request->input('penerbit');
            $bukubuku->tahun_terbit = $request->input('tahun_terbit');
            $bukubuku->save();

            // Simpan relasi ke tabel kategoribuku_relasi
            $kategoribuku = KategoriBukuRelasi::where('bukuid', $bukubuku->bukuid)->first();
            if (!$kategoribuku) {
                $kategoribuku = new KategoriBukuRelasi();
            }
            $kategoribuku->bukuid = $bukubuku->bukuid; // Menyimpan id buku yang baru saja disimpan
            $kategoribuku->kategoriid = $request->input('kategoriid'); // Menyimpan id kategori yang diberikan
            $kategoribuku->save();

            $messageKey = 'book.update';
            return redirect()
                ->route('dashboard.books')
                ->with('message', __('message.book.update', ['title' => $request->input('title')]));
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
        $title = $bukubuku->title;

        $bukubuku->delete();
        $messageKey = 'book.delete';
        return redirect()
                ->route('dashboard.books')
                ->with('message', __('message.book.delete', ['title' => $title]));
    }

    public function baca(Bukubuku $buku)
    {
        $pdfPath = storage_path('app/public/pdf/' . $buku->pdf);
        return response()->file($pdfPath);
    }

}

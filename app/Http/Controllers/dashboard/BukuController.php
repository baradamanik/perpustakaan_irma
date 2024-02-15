<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bukubuku;
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
            $bukubuku = new Bukubuku(); //Tambahkan ini untuk membuat objek Buku
            $image = $request->file('thumbnail');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/buku', $image, $filename);
<<<<<<< HEAD
    
=======

>>>>>>> cea9d2771a067ae9c871a6cd738fcb8daaa1cc9b
            $bukubuku->title = $request->input('title');
            $bukubuku->description = $request->input('description');
            $bukubuku->thumbnail = $filename; //Ganti dengan nama file yang baru diupload
            $bukubuku->penulis = $request->input('penulis');
            $bukubuku->penerbit = $request->input('penerbit');
            $bukubuku->tahun_terbit = $request->input('tahun_terbit');
<<<<<<< HEAD
    
            $pdf = $request->file('pdf');
            $pdfFileName = time() . '.' . $pdf->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/pdf', $pdf, $pdfFileName);
    
            $bukubuku->pdf = $pdfFileName; // Simpan nama file PDF ke dalam atribut 'pdf'
            
            $bukubuku->save();
    
            return redirect()
                ->route('dashboard.books')
                ->with('message', __('message.store', ['title'=>$request->input('title')]));
=======
            $bukubuku->save();

            return redirect()->route('dashboard.books');
>>>>>>> cea9d2771a067ae9c871a6cd738fcb8daaa1cc9b
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
        $validator = Validator::make($request->all(), [
            'title'         => 'required|unique:App\Models\Bukubuku,title,'.$bukubuku->bukuid,
            'description'   => 'required',
            'thumbnail'     => 'image',
            'pdf'           => 'mimes:pdf', // Hanya izinkan file dengan ekstensi .pdf
            'penulis'       => 'required',
            'penerbit'      => 'required',
            'tahun_terbit'  => 'required'
        ]);
        //$validator = Validator::make($request->all(), [
            //'resume'   => 'mimes:doc,pdf,docx,png,jpeg,jpg'
        //]);

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

            return redirect()
                        ->route('dashboard.books')
                        ->with('message', __('message.update', ['title'=>$request->input('title')]));
        }

        if ($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');
            $pdfFileName = time() . '.' . $pdf->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/pdf', $pdf, $pdfFileName);
            $bukubuku->pdf = $pdfFileName;
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
        return redirect()
                ->route('dashboard.books')
                ->with('message', __('message.delete', ['title' => $title]));
    }

    public function baca(Bukubuku $buku)
    {
        $pdfPath = storage_path('app/public/pdf/' . $buku->pdf);
        return response()->file($pdfPath);
    }

}

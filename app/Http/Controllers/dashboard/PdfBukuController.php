<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\Models\Bukubuku;
use Illuminate\Support\Facades\View;

class PdfBukuController extends Controller
{
    public function generatePdf()
    {
        $books = Bukubuku::all(); // Ambil semua data buku

        // Render view ke dalam HTML
        $html = View::make('pdf.buku', compact('books'))->render();

        // Buat objek Dompdf
        $pdf = new Dompdf();

        // Memasukkan HTML ke dalam Dompdf
        $pdf->loadHtml($html);

        // Render PDF
        $pdf->render();

        // Menghasilkan dan mengunduh PDF dengan nama tertentu
        return $pdf->stream('laporan-buku.pdf');
    }
}

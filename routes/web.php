<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function(){

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Dashboard
Route::get('/dashboard', [App\Http\Controllers\dashboard\DashboardController::class, 'index'])->name('dashboard');

//users
Route::get('/dashboard/users', [App\Http\Controllers\dashboard\UserController::class, 'index'])->name('dashboard');
Route::get('/dashboard/user/edit/{id}', [App\Http\Controllers\dashboard\UserController::class, 'edit'])->name('home');
Route::post('/dashboard/user/update/{id}', [App\Http\Controllers\dashboard\UserController::class, 'update'])->name('home');
Route::delete('/dashboard/user/delete/{id}', [App\Http\Controllers\dashboard\UserController::class, 'destroy'])->name('home');

//menu
Route::get('/dashboard', [App\Http\Controllers\dashboard\DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/movies', [App\Http\Controllers\dashboard\MovieController::class, 'index'])->name('dashboard.movies');
Route::get('/dashboard/books', [App\Http\Controllers\dashboard\BukuController::class, 'index'])->name('dashboard.books');
Route::get('/dashboard/peminjaman', [App\Http\Controllers\dashboard\PeminjamanController::class, 'index'])->name('dashboard.peminjaman');
Route::get('/dashboard/pengembalian', [App\Http\Controllers\dashboard\PengembalianController::class, 'index'])->name('dashboard.pengembalian');
Route::get('/dashboard/users', [App\Http\Controllers\dashboard\UserController::class, 'index'])->name('dashboard.users');

//buku
Route::get('/dashboard/books', [App\Http\Controllers\dashboard\BukuController::class, 'index'])->name('dashboard.books');
Route::get('/dashboard/books/create', [App\Http\Controllers\dashboard\BukuController::class, 'create'])->name('dashboard.books.create');
Route::get('/dashboard/books/edit/{bukubuku}', [App\Http\Controllers\dashboard\BukuController::class, 'edit'])->name('dashboard.books.edit');
Route::put('/dashboard/books/edit/{bukubuku}', [App\Http\Controllers\dashboard\BukuController::class, 'update'])->name('dashboard.books.update');
Route::post('/dashboard/books', [App\Http\Controllers\dashboard\BukuController::class, 'store'])->name('dashboard.books.store');
Route::delete('/dashboard/books/{bukubuku}', [App\Http\Controllers\dashboard\BukuController::class, 'destroy'])->name('dashboard.books.delete');

//kategoribuku
Route::get('/dashboard/kategoribuku', [App\Http\Controllers\dashboard\KategoriBukuController::class, 'index'])->name('dashboard.kategoribuku');
Route::get('/dashboard/kategoribuku/create', [App\Http\Controllers\dashboard\KategoriBukuController::class, 'create'])->name('dashboard.kategoribuku.create');
Route::get('/dashboard/kategoribuku/edit/{kategoriBuku}', [App\Http\Controllers\dashboard\KategoriBukuController::class, 'edit'])->name('dashboard.kategoribuku.edit');
Route::put('/dashboard/kategoribuku/edit/{kategoriBuku}', [App\Http\Controllers\dashboard\KategoriBukuController::class, 'update'])->name('dashboard.kategoribuku.update');
Route::post('/dashboard/kategoribuku', [App\Http\Controllers\dashboard\KategoriBukuController::class, 'store'])->name('dashboard.kategoribuku.store');
Route::delete('/dashboard/kategoribuku/{kategoriBuku}', [App\Http\Controllers\dashboard\KategoriBukuController::class, 'destroy'])->name('dashboard.kategoribuku.delete');

//kategoribukurelasi
Route::get('/dashboard/kategoribukurelasi', [App\Http\Controllers\dashboard\KategoriBukuRelasiController::class, 'index'])->name('dashboard.kategoribukurelasi');
Route::get('/dashboard/kategoribukurelasi/create', [App\Http\Controllers\dashboard\KategoriBukuRelasiController::class, 'create'])->name('dashboard.kategoribukurelasi.create');
Route::get('/dashboard/kategoribukurelasi/edit/{kategoriBukuRelasi}', [App\Http\Controllers\dashboard\KategoriBukuRelasiController::class, 'edit'])->name('dashboard.kategoribukurelasi.edit');
Route::put('/dashboard/kategoribukurelasi/edit/{kategoriBukuRelasi}', [App\Http\Controllers\dashboard\KategoriBukuRelasiController::class, 'update'])->name('dashboard.kategoribukurelasi.update');
Route::post('/dashboard/kategoribukurelasi', [App\Http\Controllers\dashboard\KategoriBukuRelasiController::class, 'store'])->name('dashboard.kategoribukurelasi.store');
Route::delete('/dashboard/kategoribukurelasi/{kategoriBukuRelasi}', [App\Http\Controllers\dashboard\KategoriBukuRelasiController::class, 'destroy'])->name('dashboard.kategoribukurelasi.delete');

//koleksipribadi
Route::get('/dashboard/koleksipribadi', [App\Http\Controllers\dashboard\KoleksiPribadiController::class, 'index'])->name('dashboard.koleksipribadi');
Route::get('/dashboard/koleksipribadi/create', [App\Http\Controllers\dashboard\KoleksiPribadiController::class, 'create'])->name('dashboard.koleksipribadi.create');
Route::get('/dashboard/koleksipribadi/edit/{koleksipribadi}', [App\Http\Controllers\dashboard\KoleksiPribadiController::class, 'edit'])->name('dashboard.koleksipribadi.edit');
Route::put('/dashboard/koleksipribadi/edit/{koleksipribadi}', [App\Http\Controllers\dashboard\KoleksiPribadiController::class, 'update'])->name('dashboard.koleksipribadi.update');
Route::post('/dashboard/koleksipribadi', [App\Http\Controllers\dashboard\KoleksiPribadiController::class, 'store'])->name('dashboard.koleksipribadi.store');
Route::delete('/dashboard/koleksipribadi/{koleksipribadi}', [App\Http\Controllers\dashboard\KoleksiPribadiController::class, 'destroy'])->name('dashboard.koleksipribadi.delete');


//baca
Route::get('/dashboard/books/{buku}/baca', [App\Http\Controllers\dashboard\BukuController::class,'baca'])->name('dashboard.books.baca');

//movie
Route::get('/dashboard/movies', [App\Http\Controllers\dashboard\MovieController::class, 'index'])->name('dashboard.movies');
Route::get('/dashboard/movies/create', [App\Http\Controllers\dashboard\MovieController::class, 'create'])->name('dashboard.movies.create');
Route::get('/dashboard/movies/edit/{movie}', [App\Http\Controllers\dashboard\MovieController::class, 'edit'])->name('dashboard.movies.edit');
Route::put('/dashboard/movies/edit/{movie}', [App\Http\Controllers\dashboard\MovieController::class, 'update'])->name('dashboard.movies.update');
Route::post('/dashboard/movies', [App\Http\Controllers\dashboard\MovieController::class, 'store'])->name('dashboard.movies.store');
Route::delete('/dashboard/movies/{movie}', [App\Http\Controllers\dashboard\MovieController::class, 'destroy'])->name('dashboard.movies.delete');

//peminjaman
Route::get('/dashboard/peminjaman', [App\Http\Controllers\dashboard\PeminjamanController::class, 'index'])->name('dashboard.peminjaman');
Route::get('/dashboard/peminjaman/create', [App\Http\Controllers\dashboard\PeminjamanController::class, 'create'])->name('dashboard.peminjaman.create');
Route::get('/dashboard/peminjaman/edit/{pinjam}', [App\Http\Controllers\dashboard\PeminjamanController::class, 'edit'])->name('dashboard.peminjaman.edit');
Route::put('/dashboard/peminjaman/edit/{pinjam}', [App\Http\Controllers\dashboard\PeminjamanController::class, 'update'])->name('dashboard.peminjaman.update');
Route::post('/dashboard/peminjaman', [App\Http\Controllers\dashboard\PeminjamanController::class, 'store'])->name('dashboard.peminjaman.store');
Route::delete('/dashboard/peminjaman/{pinjam}', [App\Http\Controllers\dashboard\PeminjamanController::class, 'destroy'])->name('dashboard.peminjaman.delete');


});
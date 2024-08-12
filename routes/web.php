<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Materi;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('index');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('auth');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('store.peserta');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $today = Carbon::today();

        if (Auth::check()) {
            $user = Auth::user();
            $isUserAdmin = $user->role === 'admin';

            if ($isUserAdmin) {
                $kategori = Kategori::whereDate('created_at', $today)->get();
                $materi = Materi::whereDate('created_at', $today)->get();
                $jumlah_materi = Materi::count();
            } else {
                $kategori = Kategori::whereDate('created_at', $today)->get();
                $materi = Materi::whereDate('created_at', $today)->where('id_kategori', $user->id_kategori)->get();
                $jumlah_materi = Materi::where('id_kategori', $user->id_kategori)->count();
            }

            return view('dashboard.index', [
                'kategori' => $kategori,
                'materi' => $materi,
                'jumlah_peserta' => User::where('validasi', 'diterima')->count(),
                'jumlah_materi' => $jumlah_materi,
                'jumlah_kategori' => Kategori::count(),
            ]);
        }

        return redirect()->route('login');
    })->name('dashboard');

    Route::put('/dashboard/{id_user}/update', [KategoriController::class, 'pilih'])->name('pilih.kategori');

    Route::get('/dashboard/peserta', [PesertaController::class, 'index'])->name('peserta');
    Route::put('/dashboard/peserta/{id_user}/terima', [PesertaController::class, 'terima'])->name('terima_peserta');
    Route::put('/dashboard/peserta/{id_user}/tolak', [PesertaController::class, 'tolak'])->name('tolak_peserta');
    Route::delete('/dashboard/peserta/{id_user}/hapus', [PesertaController::class, 'destroy'])->name('hapus_peserta');

    Route::get('/dashboard/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::post('/dashboard/kategori/tambah', [KategoriController::class, 'store'])->name('tambah_kategori');
    Route::put('/dashboard/kategori/{id_kategori}/update', [KategoriController::class, 'update'])->name('edit_kategori');
    Route::put('/dashboard/kategori/{id_user}/ubah', [KategoriController::class, 'ubah'])->name('ubah_kategori');
    Route::delete('/dashboard/kategori/{id_kategori}/hapus', [KategoriController::class, 'destroy'])->name('hapus_kategori');

    Route::get('/dashboard/materi', [MateriController::class, 'index'])->name('materi');
    Route::post('/dashboard/materi/tambah', [MateriController::class, 'store'])->name('tambah_materi');
    Route::put('/dashboard/materi/{id_materi}/update', [MateriController::class, 'update'])->name('edit_materi');
    Route::delete('/dashboard/materi/{id_materi}/hapus', [MateriController::class, 'destroy'])->name('hapus_materi');

    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/dashboard/profile/{id_user}/update', [ProfileController::class, 'update'])->name('update_profile');
    Route::put('/dashboard/profile/{id_user}/psd', [ProfileController::class, 'change_password'])->name('ubah_password');

    Route::post('/dashboard/logout', [AuthController::class, 'logout'])->name('logout');
});

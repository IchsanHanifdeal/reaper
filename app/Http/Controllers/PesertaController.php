<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jumlah_peserta_menunggu_konfirmasi = User::where('validasi', 'menunggu_konfirmasi')
            ->where('role', '<>', 'admin')
            ->count();

        $jumlah_peserta_diterima = User::where('validasi', 'diterima')
            ->where('role', '<>', 'admin')
            ->count();

        $jumlah_peserta_ditolak = User::where('validasi', 'ditolak')
            ->where('role', '<>', 'admin')
            ->count();

        $peserta = User::where('role', 'user')->get();

        return view('dashboard.peserta', [
            'jumlah_peserta_menunggu_konfirmasi' => $jumlah_peserta_menunggu_konfirmasi,
            'jumlah_peserta_diterima' => $jumlah_peserta_diterima,
            'jumlah_peserta_ditolak' => $jumlah_peserta_ditolak,
            'peserta' => $peserta,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function terima(Request $request, $id_user)
    {
        $peserta = User::findOrFail($id_user);

        $peserta->validasi = 'diterima';
        $peserta->save();

        return redirect()->back()->with('toast', [
            'message' => 'Peserta berhasil diterima.',
            'type' => 'success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function tolak(Request $request, $id_user)
    {
        $peserta = User::findOrFail($id_user);

        $peserta->validasi = 'ditolak';
        $peserta->save();

        return redirect()->back()->with('toast', [
            'message' => 'Peserta berhasil ditolak.',
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function destroy($id_user)
    {
        $peserta = User::findOrFail($id_user);

        $peserta->delete();

        return redirect()->back()->with('toast', [
            'message' => 'Peserta berhasil dihapus.',
            'type' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}

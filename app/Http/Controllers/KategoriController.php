<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::withCount([
            'users as jumlah_pemilih' => function ($query) {
                $query->where('validasi', 'diterima');
            },
            'materi'
        ])->get();

        return view('dashboard.kategori', [
            'kategori' => $kategori,
            'jumlah_kategori' => Kategori::count(),
            'kategori_terbaru' => Kategori::orderBy('created_at', 'desc')->first(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function pilih(Request $request, $id_user)
    {
        $request->validate([
            'kategori' => 'required|exists:kategori,id_kategori',
        ], [
            'kategori.required' => 'Kategori harus dipilih.',
            'kategori.exists' => 'Kategori yang dipilih tidak valid.',
        ]);

        $user = User::findOrFail($id_user);
        $user->id_kategori = $request->kategori;
        $user->save();

        return redirect()->back()->with('toast', [
            'message' => 'Kategori berhasil dipilih.',
            'type' => 'success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:255|unique:kategori,kode_kategori',
            'nama_kategori' => 'required|string|max:255',
        ], [
            'kode_kategori.required' => 'Kode kategori harus diisi.',
            'kode_kategori.unique' => 'Kode kategori sudah ada.',
            'nama_kategori.required' => 'Nama kategori harus diisi.',
        ]);

        Kategori::create([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->back()->with('toast', [
            'message' => 'Kategori berhasil ditambahkan.',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function ubah(Request $request, $id_kategori)
    {
        $request->validate([
            'kategori' => 'required|exists:kategori,id_kategori',
        ], [
            'kategori.required' => 'Kategori harus dipilih.',
            'kategori.exists' => 'Kategori yang dipilih tidak valid.',
        ]);

        $user = User::where('id_kategori', $id_kategori)->firstOrFail();

        $user->id_kategori = $request->kategori;
        $user->validasi = 'menunggu validasi';
        $user->save();

        return redirect()->back()->with('toast', [
            'message' => 'Kategori berhasil diubah dan sedang menunggu persetujuan.',
            'type' => 'success',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_kategori)
    {
        // Validasi input
        $request->validate([
            'kode_kategori' => 'required|string|max:255|unique:kategori,kode_kategori,' . $id_kategori . ',id_kategori',
            'nama_kategori' => 'required|string|max:255',
        ], [
            'kode_kategori.required' => 'Kode kategori harus diisi.',
            'kode_kategori.unique' => 'Kode kategori sudah ada.',
            'nama_kategori.required' => 'Nama kategori harus diisi.',
        ]);

        $kategori = Kategori::findOrFail($id_kategori);

        $kategori->update([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->back()->with('toast', [
            'message' => 'Kategori berhasil diperbarui.',
            'type' => 'success',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->delete();

        return redirect()->back()->with('toast', [
            'message' => 'Kategori berhasil dihapus.',
            'type' => 'success',
        ]);
    }
}

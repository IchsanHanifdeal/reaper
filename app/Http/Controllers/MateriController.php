<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $materi = Materi::all();
            $jumlah_materi = Materi::count();
            $materi_terbaru = Materi::orderBy('created_at', 'desc')->first();
        } else {
            $id_kategori = Auth::user()->id_kategori;
            $materi = Materi::where('id_kategori', $id_kategori)->get();
            $jumlah_materi = Materi::where('id_kategori', $id_kategori)->count();
            $materi_terbaru = Materi::where('id_kategori', $id_kategori)
                ->orderBy('created_at', 'desc')
                ->first();
        }
    
        return view('dashboard.materi', [
            'materi' => $materi,
            'kategori' => Kategori::all(),
            'jumlah_materi' => $jumlah_materi,
            'materi_terbaru' => $materi_terbaru,
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Materi $materi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materi $materi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materi $materi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materi $materi)
    {
        //
    }
}

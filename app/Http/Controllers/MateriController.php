<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'kode_materi' => 'required|string|max:255',
            'nama_materi' => 'required|string|max:255',
            'id_kategori' => 'required|integer|exists:kategori,id_kategori',
            'file_materi' => 'required|file|mimes:pdf,jpg,jpeg,png,mp4|max:20480', // Adjust size limit as needed
        ], [
            'kode_materi.required' => 'Kode materi harus diisi.',
            'kode_materi.string' => 'Kode materi harus berupa string.',
            'kode_materi.max' => 'Kode materi tidak boleh lebih dari 255 karakter.',
            'nama_materi.required' => 'Nama materi harus diisi.',
            'nama_materi.string' => 'Nama materi harus berupa string.',
            'nama_materi.max' => 'Nama materi tidak boleh lebih dari 255 karakter.',
            'id_kategori.required' => 'Kategori harus dipilih.',
            'id_kategori.integer' => 'Kategori harus berupa angka.',
            'id_kategori.exists' => 'Kategori yang dipilih tidak ada.',
            'file_materi.required' => 'File materi harus diunggah.',
            'file_materi.file' => 'File materi harus berupa file.',
            'file_materi.mimes' => 'File materi harus berupa file dengan ekstensi: pdf, jpg, jpeg, png, mp4.',
            'file_materi.max' => 'Ukuran file materi tidak boleh lebih dari 20 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('file_materi')) {
            $file = $request->file('file_materi');
            $fileName = time() . '.' . $file->extension();
            $filePath = $file->storeAs('public/materi', $fileName);
        } else {
            $filePath = null;
        }

        $materi = Materi::create([
            'tanggal_upload' => now(),
            'kode_materi' => $request->input('kode_materi'),
            'nama_materi' => $request->input('nama_materi'),
            'id_kategori' => $request->input('id_kategori'),
            'file_materi' => $filePath ? str_replace('public/', '', $filePath) : null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Materi berhasil ditambahkan.',
        ]);
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
    public function update(Request $request, $id_materi)
    {
        $validator = Validator::make($request->all(), [
            'kode_materi' => 'required|string|max:255|unique:materi,kode_materi,' . $id_materi,
            'nama_materi' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'file_materi' => 'nullable|file|mimes:pdf,mp4,jpg,jpeg,png|max:10240', // Adjust max size as needed
        ], [
            'kode_materi.required' => 'Kode materi harus diisi.',
            'kode_materi.unique' => 'Kode materi sudah ada.',
            'nama_materi.required' => 'Nama materi harus diisi.',
            'id_kategori.required' => 'Kategori harus dipilih.',
            'id_kategori.exists' => 'Kategori yang dipilih tidak valid.',
            'file_materi.file' => 'File materi harus berupa file.',
            'file_materi.mimes' => 'File materi harus berupa PDF, MP4, JPG, JPEG, atau PNG.',
            'file_materi.max' => 'File materi maksimal 10 MB.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $materi = Materi::findOrFail($id_materi);
        $materi->kode_materi = $request->kode_materi;
        $materi->nama_materi = $request->nama_materi;
        $materi->id_kategori = $request->id_kategori;

        if ($request->hasFile('file_materi')) {
            if ($materi->file_materi && Storage::exists('public/' . $materi->file_materi)) {
                Storage::delete('public/' . $materi->file_materi);
            }

            $file = $request->file('file_materi');
            $path = $file->store('materi', 'public');
            $materi->file_materi = $path;
        }

        $materi->save();

        return redirect()->back()->with('toast', [
            'message' => 'Materi berhasil diperbarui.',
            'type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_materi)
    {
        $materi = Materi::findOrFail($id_materi);

        if ($materi->file_materi && Storage::exists('public/materi/' . $materi->file_materi)) {
            Storage::delete('public/materi/' . $materi->file_materi);
        }

        $materi->delete();

        return redirect()->back()->with('toast', [
            'message' => 'Materi berhasil dihapus.',
            'type' => 'success',
        ]);
    }
}

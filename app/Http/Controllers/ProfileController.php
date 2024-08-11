<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $login = $request->session()->get('login_time');
        return view('dashboard.profile', [
            'login' => $login,
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
    public function show(string $id)
    {
        //
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
    public function update(Request $request, $id_user)
    {
        $user = Auth::user();

        // Validate the input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tempat' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the user profile
        $user->update([
            'nama' => $request->input('nama'),
            'tempat' => $request->input('tempat'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'alamat' => $request->input('alamat'),
            'no_hp' => $request->input('no_hp'),
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function change_password(Request $request, $id_user)
    {
        $user = Auth::user();

        // Validate the input
        $validator = Validator::make($request->all(), [
            'password_lama' => 'required|string|min:8',
            'password_baru' => 'required|string|min:8|confirmed',
            'konfirmasi_password_baru' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!Hash::check($request->input('password_lama'), $user->password)) {
            return redirect()->back()->withErrors(['password_lama' => 'The current password is incorrect.'])->withInput();
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->input('password_baru')),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}

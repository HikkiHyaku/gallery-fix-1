<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyalbumsController extends Controller
{
    public function index()
    {
        // Ambil ID pengguna yang sedang masuk
        $userId = Auth::id();

        // Ambil semua data album milik pengguna yang sedang masuk
        $albums = Album::where('id', $userId)->get();

        // Kembalikan view 'albums.index' dan kirim data album
        return view('myalbums.index', ['albums' => $albums]);
    }
}

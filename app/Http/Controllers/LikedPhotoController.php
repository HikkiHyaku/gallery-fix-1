<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Like;

class LikedPhotoController extends Controller
{
    public function index()
    {
        // Mengambil semua foto yang sudah disukai
        $likedPhotos = Photo::whereHas('like')->with("album", "like", "photoComments")->get();

        // Mengirim data foto ke view
        return view('liked_photos.index', compact('likedPhotos'));
    }
}


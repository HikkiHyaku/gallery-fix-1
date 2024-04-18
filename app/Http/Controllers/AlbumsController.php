<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class AlbumsController extends Controller
{
    public function index()
    {
        $albums = Album::paginate(6); // Change 10 to your desired number of items per page
        return view('albums.index', compact('albums'));
    }

    public function create()
    {
        return view('albums.create');
    }

    public function show(Album $album)
    {
        // Menggunakan model binding, tidak perlu mencari ulang dengan findOrFail
        if (!$album) {
            abort(404); // Atau handle sesuai kebutuhan Anda
        }

        return view('albums.show', compact('album'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'cover_image' => 'required|image|max:1999',
            'description' => 'required'
        ]);

        // Upload dan simpan gambar
        $fileNameToStore = $this->uploadImage($request->file('cover_image'));

        // Buat album baru
        Album::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'cover_image' => $fileNameToStore,
        ]);

        return redirect('/albums')->with('success', 'Album created');
    }

    public function destroy($id)
    {
        $album = Album::findOrFail($id);

        // Hapus gambar terkait sebelum menghapus album
        $this->deleteImage($album->cover_image);

        // Hapus album
        $album->delete();

        return redirect('/albums')->with('danger', 'Album deleted');
    }

    // Fungsi untuk mengupload gambar
    private function uploadImage($image)
    {
        $filenameWithExt = $image->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

        // Resize gambar ke ukuran yang diinginkan (300x300)
        $resizedImage = Image::make($image)->fit(300, 300)->encode($extension);

        // Simpan gambar yang telah diresize
        Storage::put('public/album_covers/' . $fileNameToStore, $resizedImage);

        return $fileNameToStore;
    }

    // Fungsi untuk menghapus gambar
    private function deleteImage($filename)
    {
        if ($filename != 'noimage.jpg') {
            Storage::delete('public/album_covers/' . $filename);
        }
    }
}

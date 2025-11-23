<?php

namespace App\Http\Controllers;

use App\Models\Gambar;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GambarController extends Controller
{
    //

    public function index()
{
    $user = Auth::user();
    if (!$user->toko) {
        return back()->with('error', 'Anda belum memiliki toko.');
    }

    $toko = $user->toko;
    $gambars = Gambar::with('produk')
        ->whereHas('produk', function ($query) use ($toko) {
            $query->where('toko_id', $toko->id);
        })
        ->get();

    $produk = Produk::where('toko_id', $toko->id)->get();

    return view('member.gambar', compact('gambars', 'produk'));
}

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'path_gambar' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $file = $request->file('path_gambar');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('storage/imageproduk'), $fileName);

        Gambar::create([
            'produk_id' => $request->produk_id,
            'path_gambar' => $fileName
        ]);

        return back()->with('success','Gambar berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $gambar = Gambar::findOrFail($id);

        $request->validate([
            'path_gambar' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if (file_exists(public_path('storage/imageproduk/'.$gambar->path_gambar))) {
            unlink(public_path('storage/imageproduk/'.$gambar->path_gambar));
        }

        $file = $request->file('path_gambar');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('storage/imageproduk'), $fileName);

        $gambar->update([
            'path_gambar' => $fileName
        ]);

        return back()->with('success','Gambar berhasil diperbarui!');
    }

    public function delete($id)
    {
        $gambar = Gambar::findOrFail($id);

        if (file_exists(public_path('storage/imageproduk/'.$gambar->path_gambar))) {
            unlink(public_path('storage/imageproduk/'.$gambar->path_gambar));
        }

        $gambar->delete();

        return back()->with('success','Gambar berhasil dihapus!');
    }
}

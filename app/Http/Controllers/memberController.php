<?php

namespace App\Http\Controllers;

use App\Models\Gambar;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class memberController extends Controller
{
    //
    public function dashboard(){

        $toko = Toko::where('user_id', Auth::id())->first();

        if ($toko) {
            $produk = Produk::where('toko_id', $toko->id)->get();

            $gambarCount = Gambar::whereIn('produk_id', $produk->pluck('id'))->count();

            $data['produk_count'] = $produk->count();
            $data['gambar_count'] = $gambarCount;
            $data['kategori_count'] = Kategori::count();

        } else {
            $data['produk_count'] = 0;
            $data['gambar_count'] = 0;
            $data['kategori_count'] = Kategori::count();
        }

        $data['toko'] = $toko;
        return view('member.dashboard', $data);
    }


    public function produk()
    {
        $toko = Toko::where('user_id', Auth::user()->id)->first();

        if (!$toko) {
            return back()->with('error', 'Toko tidak ditemukan!');
        }

        $data['gambars'] = Gambar::whereHas('produk', function ($query) use ($toko) {
            $query->where('toko_id', $toko->id);
        })->get();

        $data['produks'] = Produk::with('gambar')
            ->where('toko_id', $toko->id)
            ->get();

        $data['kategori'] = Kategori::all();

        return view('member.produk', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'logo_toko' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'alamat'    => 'required|string',
        ]);

        $logo = null;

        if ($request->hasFile('logo_toko')) {
            $file = $request->file('logo_toko');
            $logo = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('storage/logotoko'), $logo);
        }

        Toko::create([
            'user_id' => Auth::id(),
            'alamat' => $request->alamat,
            'kontak_toko' => Auth::user()->kontak,
            'nama_toko' => $request->nama_toko,
            'status' => 'pending',
            'deskripsi' => $request->deskripsi,
            'gambar' => $logo,
        ]);

        return back()->with('success', 'Toko berhasil dibuat!');
    }
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'nama_toko' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'logo_toko' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $toko = Toko::findOrFail($request->id);

        $fileName = $toko->gambar;

        if ($request->hasFile('logo_toko')) {
            if ($toko->gambar && file_exists(public_path('storage/image/'.$toko->gambar))) {
                unlink(public_path('storage/image/'.$toko->gambar));
            }

            $file = $request->file('logo_toko');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/image'), $fileName);
        }

        $toko->update([
            'nama_toko' => $request->nama_toko,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $fileName
        ]);

        return back()->with('success','Toko berhasil diperbarui!');
    }
}

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
        return view('member.dashboard');
    }

    public function produk()
    {
        $toko_id = Auth::user()->Toko->id;
        $data['gambars'] = Gambar::whereHas('produk', function ($query) use ($toko_id) {
                                    $query->where('toko_id', $toko_id);
                                })->get();
        $data['produks'] = Produk::with('Gambar')
                                ->where('toko_id', $toko_id)
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

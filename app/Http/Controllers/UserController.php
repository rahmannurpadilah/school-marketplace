<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    //
    public function homepage()
    {
        $data['tokos'] = Toko::where('status', 'active')
            ->latest()
            ->take(9)
            ->get();

        $data['produks'] = Produk::with(['toko', 'kategori', 'Gambar'])
            ->latest()
            ->take(8)
            ->get();
        return view('user.home', $data);
    }

    public function produkpage(Request $request)
    {
        $data['kategoris'] = Kategori::orderBy('nama_kategori')->get();

        $query = Produk::with(['Toko', 'Kategori', 'Gambar']);

        if ($request->search) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        if ($request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }

        $data['produks'] = $query->latest()->get();

        return view('user.produk', $data);
    }

    public function tokopage(Request $request)
    {
        // Search toko
        $query = Toko::where('status', 'active');

        if ($request->search) {
            $query->where('nama_toko', 'like', '%' . $request->search . '%');
        }

        $data['tokos'] = $query->latest()->get();

        return view('user.toko', $data);
    }

    public function detailtoko($id){
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        $data['toko'] = Toko::findOrFail($id);

        $data['produk'] = Produk::with('Gambar')
            ->where('toko_id', $id)
            ->latest()
            ->get();

        return view('user.detailtoko', $data);
    }

    public function detailproduk($id){
        $decryptId = Crypt::decrypt($id);

        $produk = Produk::with(['Gambar', 'Kategori'])->findOrFail($decryptId);

        $data['toko'] = Toko::find($produk->toko_id); // FIX
        $data['produk'] = $produk;
        $data['gambar'] = $produk->Gambar;

        return view('user.produkdetail', $data);
    }


}

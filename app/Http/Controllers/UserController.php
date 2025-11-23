<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;

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


}

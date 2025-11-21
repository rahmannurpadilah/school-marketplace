<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function memberHome(){
    $data['tokos'] = Toko::latest()->where('status','active')->take(9)->get();

    $data['produks'] = Produk::with(['toko', 'kategori', 'Gambar'])
                              ->latest()
                              ->get();

    return view('user.home', $data);
}
}

<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    //

    //admin
    public function index(){
        $data['kategori'] = Kategori::all();
        return view('admin.kategori',$data);
    }
    public function store (Request $request){
        $request -> validate([
            'nama_katgori' => 'required'
        ]);
        Kategori::create([
            'nama_katgori' => $request -> nama_katgori
        ]);
        return redirect() -> back() -> with ('success', 'Kategori Berhasil Ditambahkan');
    }
    public function Update (Request $request){
        Kategori::where('id',$request -> id)->Update([
            'nama_katgori' => $request -> nama_katgori
        ]);
        return redirect() -> back() -> with ('success', 'Kategori Berhasil Diupdate');
    }
    public function delete ($id){
        Kategori::where('id',$id)->delete();
        return redirect() -> back() -> with ('success', 'Kategori Berhasil Dihapus');
    }
}

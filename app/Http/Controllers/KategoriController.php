<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    //

    //admin
    public function index(){
        $data['kategori'] = Kategori::all();

        if (Auth::user()->role == 'admin') {
            return view('admin.kategori',$data);
        }else if (Auth::user()->role == 'member'){
            return view('member.kategori',$data);
        }else {
            return redirect()->route('login');
        }
    }
    
    public function store (Request $request){
        $request -> validate([
            'nama_kategori' => 'required'
        ]);
        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);
        return redirect()->back()->with('success', 'Kategori Berhasil Ditambahkan');
    }
    public function Update (Request $request){
        Kategori::where('id',$request -> id)->Update([
            'nama_katgori' => $request->nama_katgori
        ]);
        return redirect()->back()->with('success', 'Kategori Berhasil Diupdate');
    }
    public function delete ($id){
        Kategori::where('id',$id)->delete();
        return redirect()->back()->with('success', 'Kategori Berhasil Dihapus');
    }
}

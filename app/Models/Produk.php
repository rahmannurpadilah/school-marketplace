<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    //
    protected $guarded = [];

    public function Toko (){
        return $this -> belongsTo(Toko::class , 'toko_id');
    }
    public function Kategori (){
        return $this -> belongsTo(Kategori::class , 'kategori_id');
    }
    public function Gambar(){
        return $this -> hasMany(Gambar::class , 'produk_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gambar extends Model
{
    //
    protected $guarded = [];

    public function Produk (){
        return $this -> belongsTo(Produk::class , 'produk_id');
    }
}

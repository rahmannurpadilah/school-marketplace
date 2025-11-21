<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    //
    protected $guarded = [];

    public function User (){
        return $this -> belongsTo(User::class , 'user_id');
    }
    public function Produk (){
        return $this -> hasMany(Produk::class , 'toko_id');
    }
}

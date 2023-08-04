<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    //
    protected $table ="carts";
    protected $guarded = [];

    public function product(){
        return $this->hasOne(Products::class,'id','product_id');
    }
}

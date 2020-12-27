<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cartProduct extends Model
{
    protected $fillable = ['id','cart_id', 'product_id','quantity'];
}

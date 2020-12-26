<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cart_product extends Model
{
    protected $fillable = ['id','cart_id', 'product_id'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewHistory extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'category_id',
        'brand_id',
    ];
}

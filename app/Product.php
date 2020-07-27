<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'code'];

    public function warehouses()
    {
        return $this->belongsToMany('App\Warehouse')->withPivot('stock_level')->withTimestamps();
    }
}

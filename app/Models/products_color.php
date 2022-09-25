<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products_color extends Model
{
    use HasFactory;
    public function products_size()
    {
        return $this->hasMany(products_size::class, 'color_id', 'id');
    }
    public function products_versions()
    {
        return $this->hasMany(Products_version::class, 'product_color_id', 'id');
    }
}
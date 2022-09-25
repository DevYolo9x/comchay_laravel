<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'alanguage',
        'title',
        'slug',
        'catalogue_id',
        'image',
        'image_json',
        'description',
        'content',
        'code',
        'price',
        'price_sale',
        'price_contact',
        'catalogue',
        'version_json',
        'meta_title',
        'meta_description',
        'order',
        'publish',
        'ishome',
        'highlight',
        'inventory',
        'inventoryPolicy',
        'inventoryQuantity',
        'created_at',
        'updated_at',
        'userid_created',
        'userid_updated',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function detailCategoryProduct()
    {
        return $this->hasOne(CategoryProduct::class, 'id', 'catalogue_id');
    }
    public function products_versions()
    {
        return $this->hasMany(Products_version::class, 'productid');
    }
    public function tags()
    {
        return $this->hasMany(Tags_relationship::class, 'moduleid')->select('tagid')->where('module', '=', 'products');
    }
    public function brands()
    {
        return $this->hasMany(Brands_relationships::class, 'moduleid')->select('brandid')->where('module', '=', 'products');
    }
    public function catalogues_relationships()
    {
        return $this->hasMany(Catalogues_relationships::class, 'moduleid')->select('category_products.title', 'category_products.id')->where('module', '=', 'products')->join('category_products', 'category_products.id', '=', 'catalogues_relationships.catalogueid');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'module_id');
    }

    public function products_color()
    {
        return $this->hasMany(products_color::class, 'product_id', 'id');
    }
}

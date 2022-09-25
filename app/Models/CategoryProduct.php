<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'description', 'image_json', 'parentid', 'image', 'meta_title', 'meta_description', 'userid_created', 'created_at', 'publish', 'alanguage', 'ishome', 'isaside', 'isfooter', 'highlight', 'icon', 'banner'

    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function countProduct()
    {
        return $this->hasMany(Catalogues_relationships::class, 'catalogueid', 'id')->where('module', '=', 'products');
    }
    public function listProductHome()
    {
        return $this->hasMany(Catalogues_relationships::class, 'catalogueid')
            ->where('catalogues_relationships.module', '=', 'products')
            ->join('products', 'products.id', '=', 'catalogues_relationships.moduleid')
            ->where(['products.publish' => 0])
            ->select('products.id', 'products.title', 'products.slug', 'products.description', 'products.image', 'products.price', 'products.price_sale', 'products.price_contact')
            ->orderBy('products.id', 'desc')->limit(8);
    }
}

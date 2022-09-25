<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'catalogueid', 'description', 'color', 'image', 'meta_title', 'meta_description', 'userid_created', 'created_at', 'publish', 'price_start', 'price_end', 'alanguage'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function catalogue()
    {
        return $this->hasOne(CategoryAttribute::class, 'id', 'catalogueid');
    }
}

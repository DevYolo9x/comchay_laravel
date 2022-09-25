<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','module', 'slug', 'description', 'image', 'meta_title', 'meta_description', 'userid_created', 'created_at', 'publish', 'order', 'userid_updated', 'updated_at', 'alanguage', 'isProduct', 'isTour', 'isArticle'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
}
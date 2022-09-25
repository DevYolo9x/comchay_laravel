<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'description', 'image', 'meta_title', 'meta_description', 'userid_created', 'userid_updated', 'created_at', 'updated_at', 'publish', 'order', 'lft', 'rgt', 'level', 'alanguage'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function listAttr()
    {
        return $this->hasMany(Attribute::class, 'catalogueid', 'id')->orderBy('order','asc')->orderBy('title','asc');
    }
}
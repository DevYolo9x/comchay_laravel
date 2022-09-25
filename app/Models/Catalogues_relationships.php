<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogues_relationships extends Model
{
    use HasFactory;
    public function products_versions()
    {
        return $this->hasMany(Products_version::class, 'productid', 'id');
    }
    public function commentsArticle()
    {
        return $this->hasMany(Comment::class, 'module_id', 'id')->where('module', '=', 'articles')->where('parentid',0);
    }
    public function tagsArticle()
    {
        return $this->hasMany(Tags_relationship::class, 'moduleid', 'id')->where('tags_relationships.module', '=', 'articles')->join('tags', 'tags.id', '=', 'tags_relationships.tagid');
    }
}

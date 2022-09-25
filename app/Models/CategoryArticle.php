<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryArticle extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'parentid', 'description', 'image', 'image_json', 'meta_title', 'meta_description', 'userid_created', 'userid_updated', 'created_at', 'updated_at', 'publish', 'order', 'alanguage', 'banner'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function listArticle()
    {
        return $this->hasMany(Catalogues_relationships::class, 'catalogueid')->where('module', '=', 'articles');
    }
    public function articles()
    {
        return $this->hasMany(Article::class, 'catalogue_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(CategoryArticle::class, 'parentid', 'id')->select('id', 'title', 'slug')->orderBy('order', 'asc')->orderBy('id', 'desc');
    }
    public function listArticleHome()
    {
        return $this->hasMany(Catalogues_relationships::class, 'catalogueid')->where('module', '=', 'articles')->join('articles', 'articles.id', '=', 'catalogues_relationships.moduleid')
            ->where(['articles.publish' => 0])
            ->select('id', 'title', 'slug', 'description', 'image')
            ->orderBy('articles.id', 'desc')->limit(4);
    }
}

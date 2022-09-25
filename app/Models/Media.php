<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = ['alanguage','title','slug','description','catalogue_id','catalogue','image','image_json','video_type','video_link','video_iframe','viewed','publish','ishome','highlight','isaside','isfooter'
    ,'order','meta_title', 'meta_description', 'userid_created','userid_updated','created_at','updated_at','layoutid','file_upload'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function getCategoryMedia()
    {
        return $this->hasOne(CategoryMedia::class, 'id', 'catalogue_id');
    }
    public function getCategoryMediaRelationships()
    {
        return $this->hasMany(Catalogues_relationships::class, 'moduleid', 'id')
        ->select('category_media.title', 'category_media.id')
        ->where('module', '=', 'media')
        ->join('category_media', 'category_media.id', '=', 'catalogues_relationships.catalogueid')
        ->groupBy('category_media.id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMedia extends Model
{
    use HasFactory;
    protected $fillable = ['alanguage','title','slug','description','image','parentid','level','lft','rgt','publish','ishome','highlight','isaside','isfooter'
    ,'order','meta_title', 'meta_description', 'userid_created','userid_updated','created_at','updated_at','layoutid'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function listMedia()
    {
        return $this->hasMany(Catalogues_relationships::class, 'catalogueid', 'id')->where('module', '=', 'media');
    }
    public function children()
    {
        return $this->hasMany(CategoryMedia::class, 'parentid','id')->orderBy('order','asc')->orderBy('id','desc');
    }
}

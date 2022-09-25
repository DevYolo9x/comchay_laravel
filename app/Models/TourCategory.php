<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'alanguage','title','slug','description','content','banner','image','image_json','video','parentid','level','lft','rgt','publish','ishome','highlight','isaside','isfooter','order','meta_title','meta_description','userid_created','userid_updated','created_at','updated_at'
    ];
    public function tours()
    {
        return $this->hasMany(Tour::class, 'catalogue_id', 'id');
    }
    public function tourCount()
    {
        return $this->hasMany(TourCategoryRelationships::class, 'tour_category_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
}
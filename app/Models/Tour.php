<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    protected $fillable = [
        'alanguage','title','slug','description','content','video','banner','image','image_json','version_json','catalogue_id','code','price','price_sale','price_contact','publish','ishome','highlight','isaside','isfooter','order','map','schedule','infoTour','meta_title','meta_description','userid_created','userid_updated','created_at','updated_at','checkin','checkout','rate','discount','available'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function getCategory()
    {
        return $this->hasOne(TourCategory::class, 'id', 'catalogue_id');
    }

    public function services()
    {
        return $this->hasMany(TourServiceRelationship::class)
        ->select('tour_services.title','tour_services.ishome','tour_services.type','tour_service_relationships.tour_service_id')
        ->join('tour_services', 'tour_services.id', '=', 'tour_service_relationships.tour_service_id')
        ->groupBy('tour_service_relationships.tour_service_id')
        ->orderBy('tour_services.type','asc')
        ->orderBy('tour_services.order','asc')
        ->orderBy('tour_services.id','desc');
    }
    public function tags()
    {
        return $this->hasMany(Tags_relationship::class, 'moduleid', 'id')->where('module', '=', 'tours');
    }
    public function catalogue()
    {
        return $this->hasMany(TourCategoryRelationships::class, 'tour_id', 'id');
    }
    public function catalogues_relationships()
    {
        return $this->hasMany(TourCategoryRelationships::class, 'tour_id')->select('tour_categories.title', 'tour_categories.slug')->join('tour_categories', 'tour_categories.id', '=', 'tour_category_relationships.tour_category_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'module_id', 'id')->where('module', '=', 'tours')->where('parentid',0);
    }
}

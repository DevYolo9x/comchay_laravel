<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags_relationship extends Model
{
    use HasFactory;
    public function article()
    {
        return $this->hasOne(Article::class, 'id', 'moduleid')->select('id', 'title','description','slug','image','created_at','userid_created');
    }
    public function tour()
    {
        return $this->hasOne(Tour::class, 'id', 'moduleid')->select('id', 'title','slug','image','price','price_sale','price_contact','rate','catalogue_id','isfooter','infoTour');
    }
}
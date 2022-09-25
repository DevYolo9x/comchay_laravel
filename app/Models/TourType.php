<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourType extends Model
{
    use HasFactory;
    protected $fillable = [
        'alanguage','title','slug','publish','order','meta_title','meta_description','userid_created','userid_updated','created_at','updated_at'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }

    public function tours()
    {
        return $this->hasMany(TourTypeRelationship::class, 'tour_type_id', 'id');
    }


}

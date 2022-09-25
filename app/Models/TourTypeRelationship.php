<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourTypeRelationship extends Model
{
    use HasFactory;
    public function getTourType()
    {
        return $this->hasOne(TourType::class, 'id', 'tour_type_id');
    }
}

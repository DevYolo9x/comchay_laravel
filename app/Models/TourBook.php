<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourBook extends Model
{
    use HasFactory;
    protected $fillable = [
        'code','status','tour_id','fullname','email','phone','address','inquiryTour','date','people','adult','children','message','created_at','updated_at','type',
    ];
    public function tour()
    {
        return $this->hasOne(Tour::class, 'id', 'tour_id');
    }
}
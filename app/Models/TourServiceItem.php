<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourServiceItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'alanguage','title','service_id','publish','order','userid_created','userid_updated','created_at','updated_at'
    ];
}

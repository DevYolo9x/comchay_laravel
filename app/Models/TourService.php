<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourService extends Model
{
    use HasFactory;
    protected $fillable = [
        'alanguage','title','slug','publish','type','ishome','order','userid_created','userid_updated','created_at','updated_at'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function items()
    {
        return $this->hasMany(TourServiceItem::class,'service_id')->orderBy('order','asc')->orderBy('id','desc');
    }
}
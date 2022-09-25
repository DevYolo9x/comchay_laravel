<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','userid_created','userid_updated','created_at','updated_at','publish','order','long','lat','image','email','hotline','address','cityid','districtid','time'
    ];
    public function user(){
        return $this->hasOne(User::class,'id','userid_created');
    }
    public function city_name(){
        return $this->hasOne(VNCity::class,'id','cityid');
    }

}

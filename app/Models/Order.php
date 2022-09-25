<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['status'];

    public function customer(){
        return $this->hasOne(Customer::class,'id','customerid');
    }
    public function city_name(){
        return $this->hasOne(VNCity::class,'provinceid','cityid');
    }
    public function district_name(){
        return $this->hasOne(VNDistrict::class,'districtid','districtid');
    }
}

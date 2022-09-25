<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','slug','order','name','description','image','type','meta_title','meta_description','userid_created','userid_updated','created_at','updated_at','publish','order','limit_user','limit','exclude_product_categories','product_categories','exclude_product_ids','product_ids','max_count','min_count','min_price','max_price','expiry_date','value','type'
    ];
    public function user(){
        return $this->hasOne(User::class,'id','userid_created');
    }
    public function coupon_relationship(){
        return $this->hasMany(Coupon_relationship::class,'couponid');
    }
    public function coupon_relationship_one(){
        return $this->hasOne(Coupon_relationship::class,'couponid');
    }
    public function coupon_order(){
        return $this->hasOne(Order::class,'id','orderid');
    }
}

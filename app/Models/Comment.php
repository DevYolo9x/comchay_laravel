<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'customerid', 'parentid', 'module_id', 'fullname', 'email', 'phone', 'message', 'images', 'avatar', 'rating', 'type', 'created_at', 'updated_at', 'publish'
    ];
    public function order()
    {
        return $this->hasMany(Order::class, 'customerid', 'customerid')->join('orders_item', 'orders_item.order_id', '=', 'orders.id')->groupBy('orders_item.product_id')->select('orders_item.*');
    }
    public function orders()
    {
        return $this->belongsTo(Order::class, 'customerid');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customerid');
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'module_id')->select('slug', 'title');
    }
    public function tour()
    {
        return $this->hasOne(Tour::class, 'id', 'module_id')->select('slug', 'title');
    }
    public function article()
    {
        return $this->hasOne(Article::class, 'id', 'module_id')->select('slug', 'title');
    }
}

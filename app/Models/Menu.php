<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['title','slug','created_at','updated_at','userid_created','userid_updated','publish'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
}

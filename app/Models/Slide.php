<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','src','link','description','order','catalogueid','userid_created','created_at','updated_at'
    ];
    public function slides(){
        return $this->belongsToMany(Slide::class);
    }
}

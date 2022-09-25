<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorySlide extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'keyword', 'userid_created', 'created_at', 'updated_at'
    ];
    public function slides()
    {
        return $this->hasMany(Slide::class, 'catalogueid', 'id')->orderBy('order','asc')->orderBy('id','desc')->where('alanguage', config('app.locale'));
    }
}
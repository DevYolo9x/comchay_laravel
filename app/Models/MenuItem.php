<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    protected $table = 'menu_items';
    protected $fillable = ['title', 'name', 'slug', 'type','image', 'target', 'menu_id', 'created_at', 'updated_at', 'alanguage'];
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parentid','id')->orderBy('order')->with('children');
    }

}
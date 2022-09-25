<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigColum extends Model
{
    protected $fillable = [
        'title', 'type', 'keyword', 'data', 'module',  'created_at', 'updated_at', 'trash', 'publish'
    ];
    use HasFactory;
    public function postmetas()
    {
        return $this->hasMany(ConfigPostmeta::class, 'config_colums_id', 'id');
    }
}

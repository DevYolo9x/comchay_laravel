<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configis extends Model
{
    protected $fillable = [
        'title', 'module', 'type', 'active', 'created_at', 'updated_at'
    ];
    use HasFactory;
}

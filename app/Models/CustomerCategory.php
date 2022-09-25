<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCategory extends Model
{
    protected $fillable = [
        'title',
        'publish',
        'order',
        'created_at',
        'updated_at'

    ];
    use HasFactory;
    public function customers()
    {
        return $this->hasMany(Customer::class, 'catalogue_id', 'id');
    }
}

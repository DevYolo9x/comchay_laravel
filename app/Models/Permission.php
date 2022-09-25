<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['title','description','key_code','parent_id'];

    public function permissionsChildren(){
        return $this->hasMany(Permission::class,'parent_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }
    public function checkPermissionAccess($key_code)
    {
        //lấy được tất cả các quyền của user trong hệ thống
        //so sánh giá trị đưa vào của router hiện tại xem có tồn tại trong các quyền lấy ở trên
        $roles = Auth::user()->roles;
        foreach ($roles as $v) {
            $permissions = $v->permissions;
            if ($permissions->contains('key_code', $key_code)) {
                return true;
            }
        }
        return false;
    }
    public function AauthAcessToken()
    {
        return $this->hasMany('\App\Models\OauthAccessToken');
    }
}
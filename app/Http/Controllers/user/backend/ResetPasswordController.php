<?php

namespace App\Http\Controllers\user\backend;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ResetPasswordController extends Controller
{
    public function index()
    {
    
        return view('user.backend.auth.reset-password');
        
    }
    public function store(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user){
            $passwordReset = PasswordReset::updateOrCreate([
                'email' => $user->email,
            ], [
                'token' => Str::random(60),
            ]);
            if ($passwordReset) {
                $user->notify(new ResetPasswordRequest($passwordReset->token));
            }
            return redirect()->route('admin.reset-password')->with('success','We have e-mailed your password reset link!');
        }else{
          
            return redirect()->route('admin.reset-password')->with('error','Tài khoản không tồn tại!');
        }
       
    }
    public function reset_password_new(Request $request)
    {
    
        $passwordReset = PasswordReset::where('token', $request->token)->firstOrFail();
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return redirect()->route('admin.reset-password')->with('error','This password reset token is invalid.');
        }
        $user = User::where('email', $passwordReset->email)->firstOrFail();
        $passwordnew = Str::random(6);
        // $passwordnew = 'admin2021!';
        User::find($user->id)->update([
            'password' => bcrypt($passwordnew),
        ]);
        $passwordReset->delete();
        return redirect()->route('admin.login')->with('success','Mật khẩu mới: '.$passwordnew);
    }
}

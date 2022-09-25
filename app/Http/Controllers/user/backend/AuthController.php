<?php

namespace App\Http\Controllers\user\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('user.backend.auth.login');
    }
    public function store(Request  $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Mật khẩu là trường bắt buộc.',
        ]);
        // $remember = $request->has('remember_me') ? true : false;
        $remember = true;
        if (auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $remember)) {
            //lấy phân quyền upload image
            $user = User::where(["email" => $request->email])->first();
            $temp_permission = [];
            $roles = auth()->user()->roles;
            foreach ($roles as $k => $v) {
                $permissions = $v->permissions;

                foreach ($permissions as $v2) {
                    if ($v2['parent_id'] == 22) {
                        $temp_permission[] = $v2['key_code'];
                    }
                }
            }
            setcookie('authImagesManager', json_encode(array(
                'domain' => env('APP_URL_UPLOAD'),
                'email' => $user->email,
                'permission' => $temp_permission,
                'folder_upload' => ($user->id * 168) * 168 + 168,
            )), time() + (86400 * 30), '/');
            //$auth = isset($_COOKIE['authImagesManager'])?$_COOKIE['authImagesManager']:NULL;
            //end
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin.login')->withInput()->withErrors('Email hoặc mật khẩu không đúng!');
        }
    }

    public function profile()
    {
        $module = 'user';
        return view('user.backend.user.profile', compact('module'));
    }
    public function profile_store(Request  $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Tên thành viên là trường bắt buộc.',
        ]);
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), 'avatar-admin');
        } else {
            $image_url = $request->image_old;
        }
        User::find($id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $image_url,

        ]);
        return redirect()->route('admin.profile')->with('success', 'Cập nhập hồ sơ thành công');
    }
    public function profile_password()
    {
        $module = 'user';
        return view('user.backend.user.profile_password', compact('module'));
    }
    public function profile_password_store(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:3|max:20',
            'confirm_password' => 'required|min:3|max:20|same:password',
        ], [
            'password.required' => 'Mật khẩu là trường bắt buộc.',
            'confirm_password.required' => 'Nhập lại mật khẩu là trường bắt buộc.',
            'confirm_password.same' => 'Nhập lại mật khẩu không khớp với mật khẩu.',
        ]);
        User::find($id)->update([
            'password' => bcrypt($request->password),
        ]);
        return redirect()->route('admin.profile-password')->with('success', 'Thay đổi mật khẩu thành công');
    }
    public function logout()
    {

        if (Auth::logout()) {
            setcookie('authImagesManager', '', time() - 86400, '/');
            return redirect()->route('admin.login');
        }
        return redirect()->route('admin.dashboard');
    }
}

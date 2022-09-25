<?php

namespace App\Http\Controllers\customer\frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Page;
use App\Models\PasswordReset;
use App\Notifications\ResetPasswordFrontend;
use Illuminate\Http\Request;
use Auth;
use Socialite;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Components\System;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->system = new System();
    }
    public function dashboard()
    {
        $fcSystem = $this->system->fcSystem();
        return view('customer/frontend/manager/information', compact('fcSystem'));
    }
    public function changepassword()
    {
        $fcSystem = $this->system->fcSystem();
        return view('customer/frontend/manager/changepassword', compact('fcSystem'));
    }
    public function storeChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|required_with:old_password|same:old_password',
        ], [
            'current_password.required' => 'Mật khẩu cũ là trường bắt buộc.',
            'old_password.required' => 'Mật khẩu mới là trường bắt buộc.',
            'new_password.required' => 'Nhập lại mật khẩu mới là trường bắt buộc.',
        ]);
        if (!Hash::check($request->current_password, Auth::guard('customer')->user()->password)) {
            return redirect()->route('customer.changepassword')->with('error', "Mật khẩu cũ không chính xác");
        }
        //Change Password
        $userId = Auth::guard('customer')->user()->id;
        $user = Customer::where('id', $userId)->update(
            ['password' => bcrypt($request->new_password)]
        );
        return redirect()->route('customer.changepassword')->with('success', "Đổi mật khẩu thành công");
    }

    public function address()
    {
        $detailPage = Page::where('page', 'address')->where('publish', 0)->select('meta_title', 'meta_description', 'title', 'description', 'image')->first();
        $seo =  seoFrontend($detailPage, route('customer.address'));

        $fcSystem = $this->system->fcSystem();
        return view('customer/frontend/manager/address', compact('fcSystem', 'seo', 'detailPage'));
    }
    public function orders()
    {
        $detailPage = Page::where('page', 'orders')->where('publish', 0)->select('meta_title', 'meta_description', 'title', 'description', 'image')->first();
        $seo =  seoFrontend($detailPage, route('customer.orders'));

        $fcSystem = $this->system->fcSystem();
        return view('customer/frontend/manager/orders', compact('fcSystem', 'seo', 'detailPage'));
    }

    public function login()
    {
        $page = Cache::remember('pageLogin', 60, function () {
            return Page::where(['alanguage' => config('app.locale'), 'page' => 'login', 'publish' => 0])->select('meta_title', 'meta_description', 'image', 'title', 'content_item')->first();
        });
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('customer/frontend/auth/login', compact('fcSystem', 'seo'));
    }
    public function store(Request  $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email là trường bắt buộc.',
            // 'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Mật khẩu là trường bắt buộc.',
        ]);
        if (is_numeric($request->email)) {
            $array = [
                'phone' => $request->email,
                'password' => $request->password,
                'active' => 1,
            ];
        } elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $array = [
                'email' => $request->email,
                'password' => $request->password,
                'active' => 1,
            ];
        }
        if (!empty($request->remember)) {
            $remember = true;
        } else {
            $remember = false;
        }
        if (Auth::guard('customer')->attempt($array, $remember)) {
            return redirect()->route('homepage.index');
        } else {
            return redirect()->route('customer.login')->withInput()->withErrors('Email hoặc mật khẩu không đúng!');
        }
    }
    //đăng ký
    public function register()
    {
        $page = Cache::remember('pageRegister', 60, function () {
            return Page::where(['alanguage' => config('app.locale'), 'page' => 'register', 'publish' => 0])->select('meta_title', 'meta_description', 'image', 'title', 'content_item')->first();
        });
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        $fcSystem = $this->system->fcSystem();
        return view('customer/frontend/auth/register', compact('fcSystem', 'seo'));
    }
    public function register_store(Request  $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'phone' => 'required|unique:customers',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ], [
            'name.required' => 'Họ và tên là trường bắt buộc.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.required' => 'Số điện thoại là trường bắt buộc.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'password.required' => 'Mật khẩu là trường bắt buộc.',
            'password.min' => 'Mật khẩu tối thiểu là 6 kí tự.',
            'confirm_password.min' => 'Nhập lại mật khẩu tối thiểu là 6 kí tự.',
            'confirm_password.required' => 'Nhập lại mật khẩu là trường bắt buộc.',
            'confirm_password.same' => 'Nhập lại mật khẩu không khớp với mật khẩu.',
        ]);
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);

        //luu avatar mac dinh
        if ($customer) {
            $ch = curl_init('https://ui-avatars.com/api/?name=' . $customer->name);
            $img_name = '/upload/customer/' . slug($customer->name) . '-' . $customer->id . '.png';
            $fp = fopen(base_path() . $img_name, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            Customer::find($customer->id)->update(['image' => $img_name]);
        }
        return redirect()->route('customer.login')->with('success', 'Đăng ký thành viên thành công');
    }
    //quên mật khẩu
    public function reset_password()
    {
        $fcSystem = $this->system->fcSystem();
        return view('customer.frontend.auth.reset-password', compact('fcSystem'));
    }
    public function reset_password_store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
        ]);
        $user = Customer::where('email', $request->email)->first();
        if ($user) {
            $passwordReset = PasswordReset::updateOrCreate([
                'email' => $user->email,
            ], [
                'token' => Str::random(60),
            ]);
            if ($passwordReset) {
                $user->notify(new ResetPasswordFrontend($passwordReset->token));
            }
            return redirect()->route('customer.reset-password')->with('success', 'We have e-mailed your password reset link!');
        } else {
            return redirect()->route('customer.reset-password')->with('error', 'Tài khoản không tồn tại!');
        }
    }
    public function reset_password_new(Request $request)
    {

        $passwordReset = PasswordReset::where('token', $request->token)->firstOrFail();
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return redirect()->route('customer.reset-password')->with('error', 'This password reset token is invalid.');
        }
        $user = Customer::where('email', $passwordReset->email)->firstOrFail();
        $passwordnew = Str::random(8);
        Customer::find($user->id)->update([
            'password' => bcrypt($passwordnew),
        ]);
        $passwordReset->delete();
        return redirect()->route('customer.login')->with('success', 'Mật khẩu mới: ' . $passwordnew);
    }
    //đăng xuất
    public function logout()
    {
        if (Auth::guard('customer')->logout()) {
            return redirect()->route('customer.login');
        }
        return redirect()->route('customer.dashboard');
    }
    //login social
    function base64url_encode($text)
    {
        $base64 = base64_encode($text);
        $base64 = trim($base64, "=");
        $base64url = strtr($base64, "+/", "-_");
        return $base64url;
    }
    function generate_state_param()
    {
        // a random 8 digit hex, for instance
        return bin2hex(openssl_random_pseudo_bytes(4));
    }
    function generate_pkce_codes()
    {
        $random = bin2hex(openssl_random_pseudo_bytes(32)); // a random 64-digit hex
        $code_verifier = $this->base64url_encode(pack('H*', $random));
        $code_challenge = $this->base64url_encode(pack('H*', hash('sha256', $code_verifier)));
        return array(
            "verifier" => $code_verifier,
            "challenge" => $code_challenge
        );
    }
    //end
    public function redirect($provider)
    {
        if ($provider == 'zalo') {
            session_start();
            $state = $this->generate_state_param(); // for CSRF prevention
            $codes = $this->generate_pkce_codes();
            $_SESSION["zalo_auth_state"] = $state;
            $_SESSION["zalo_code_verifier"] = $codes["verifier"];
            $auth_uri = 'https://oauth.zaloapp.com/v4/permission' . "?" . http_build_query(array(
                "app_id" => env('client_id_zalo'),
                "redirect_uri" => env('redirect_zalo'),
                "code_challenge" => $codes["challenge"],
                "state" => $state, // <- prevent CSRF
            ));

            header("Location: {$auth_uri}");
        } else {

            return Socialite::driver($provider)->redirect();
        }
    }
    public function callback($provider)
    {
        if ($provider == 'zalo') {
            session_start();
            $data = http_build_query(array(
                "app_id" => env('client_id_zalo'),
                "code" => $_REQUEST["code"],
                "code_verifier" => $_SESSION["zalo_code_verifier"],
                "grant_type" => "authorization_code"
            ));
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://oauth.zaloapp.com/v4/access_token',
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "secret_key: " . env('client_secret_zalo')
                ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_FAILONERROR => true,
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $auth = json_decode($response, true);
            $getInfo = curl_api('https://graph.zalo.me/v2.0/me?access_token=' . $auth["access_token"] . '&fields=id,name,picture');
            $image  = $getInfo->picture->data->url;
            $email = slug($getInfo->name) . $getInfo->id . '@gmail.com';
            unset($_SESSION["zalo_auth_state"]);
            unset($_SESSION["zalo_code_verifier"]);
        } else {
            $getInfo = Socialite::driver($provider)->user();
            $image = $getInfo->avatar;
            $email = !empty($getInfo->email) ? $getInfo->email : slug($getInfo->name) . $getInfo->id . '@gmail.com';
        }
        $checkUser = Customer::where('provider', '!=', $provider)->where('email', $email)->first();
        if ($checkUser) {
            return redirect()->route('customer.login')->withInput()->withErrors('Email đã được sử dụng!');
        } else {
            $user = Customer::where('provider_id', $getInfo->id)->first();
            if (!$user) {
                $user = Customer::create([
                    'name'     => $getInfo->name,
                    'email'    => $email,
                    'provider' => $provider,
                    'provider_id' => $getInfo->id,
                    'image' => $image
                ]);
            }
            Auth::guard('customer')->login($user);
            return redirect()->route('customer.dashboard');
        }
    }
}

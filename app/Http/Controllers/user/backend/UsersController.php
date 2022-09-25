<?php
namespace App\Http\Controllers\user\backend;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class UsersController extends Controller
{
    public function __construct()
    {
        $this->module = 'users';
    }
    public function index()
    {
        $module =  $this->module;
        $data = User::latest()->paginate(20);
        return view('user.backend.user.index',compact('data','module'));
    }
    public function create()
    {
        $module =  $this->module;
        $roles = DB::table('roles')
        ->select('id','title')
        ->get();
        return view('user.backend.user.create',compact('module','roles'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:20',
            'confirm_password' => 'required|min:6|max:20|same:password',
            'role_id' => 'required',
        ],[
            'name.required' => 'Tên thành viên là trường bắt buộc.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Mật khẩu là trường bắt buộc.',
            'confirm_password.required' => 'Nhập lại mật khẩu là trường bắt buộc.',
            'confirm_password.same' => 'Nhập lại mật khẩu không khớp với mật khẩu.',
            'role_id.required' => 'Chọn nhóm thành viên là trường bắt buộc',
        ]);
        if(!empty($request->file('image'))){
            $image_url = uploadImage($request->file('image'),'avatar-admin');
        }else{
            $image_url = '';
        }
        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $image_url,
            'address' => $request->address,
            'password' =>bcrypt($request->password),
            'created_at' => Carbon::now(),

        ]);
        $user->roles()->attach($request->role_id);
        return redirect()->route('users.index')->with('success','Thêm mới thành viên thành công');
    }
    public function edit(Request $request,$id)
    {
        $module =  $this->module;
        $roles = DB::table('roles')
        ->select('id','title')
        ->get();
        $detail =  User::find($id);
        $role_user = DB::table('role_user')
            ->select('role_id')
            ->where('user_id',$id)
            ->get();
        return view('user.backend.user.edit',compact('module','roles','detail','role_user'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'role_id' => 'required',
        ],[
            'name.required' => 'Tên thành viên là trường bắt buộc.',
            'role_id.required' => 'Chọn nhóm thành viên là trường bắt buộc',
        ]);
        if(!empty($request->file('image'))){
            $image_url = uploadImage($request->file('image'),'avatar-admin');
        }else{
            $image_url = $request->image_old;
        }
        User::find($id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $image_url,

        ]);
        $user = User::find($id);
        $user->roles()->sync($request->role_id);
        return redirect()->route('users.index')->with('success','Cập nhập thành viên thành công');
    }
    public function destroy($id)
    {
        try{
            DB::table('role_user')->where('user_id', $id)->delete();
            User::find($id)->delete();
            return response()->json([
                'code' => 200,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'code' => 500,
            ],500);
        }
    }
    public function reset_password(Request $request){
        try{
            $id = $request->id;
            User::find($id)->update([
                'password' => bcrypt('admin2021!'),
            ]);
            return response()->json([
                'code' => 200,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'code' => 500,
            ],500);
        }

    }
}
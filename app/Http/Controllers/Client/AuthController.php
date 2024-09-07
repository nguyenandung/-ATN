<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\User;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    function login(Request $request){
        $data = $request->validate([
            'username'=>'required',
            'password'=>'required'
        ],[
            'username.required'=>'Tên đăng nhập không được để trông',
            'password.required'=>'Mật khẩu không được để trống'
        ]);
        if(Auth::attempt(['name'=>$request->username, 'password'=>$request->password])){
            // dd(Auth::user()->role);
            // dd(Auth::id());
            if(Auth::user()->role=='admin'){
                return redirect()->route('dashboard');
            }
            else{
                // dd(Auth::id());
                session()->push('user_id', Auth::id());
                // dd(session()->get('user_id'));
                return redirect()->route('home');
            }
            // dd(Auth::check());
        }
        toastr()->error('Tài khoản hoặc mật khẩu sai');
        return redirect()->back()->withInput();
    }
    function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
    function register(Request $request){
        // dd('oke');
        // dd(Carbon::now());
        $data = $request->validate([
            'name'=> 'required|unique:users|min:6',
            'phonenumber'=> 'required|unique:users|min:10',
            'password'=> 'required|min:6',
            'email'=> 'required|unique:users|email',
        ],[
            'name.required'=>'Tên đăng nhập không được để trống',
            'name.unique'=>'Tên đăng nhập đã được sử dụng',
            'name.min'=>'Tên đăng nhập phải ít nhất 6 ký tự',
            'phonenumber.required'=>'Số điện thoại không được để trống',
            'phonenumber.unique'=>'Số điện thoại đã được sử dụng',
            'phonenumber.min'=>'Số điện thoại phải có 10 số',
            'password.required'=>'Mật khẩu không được để trống',
            'password.min'=>'Mật khẩu ít nhất 6 ký tự',
            'email.required'=>'Email không được để trống',
            'email.unique'=>'Email đã được sử dụng',
            'email.email'=>'Trường này phải là email',
        ]);
        // dd('a');
        // $data = $request->all();
        try {
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->created_at = Carbon::now();
            $user->phonenumber = $data['phonenumber'];
            $user->save();
            toastr()->success('Đăng ký tài khoản thành công');
            return redirect('/login');
        } catch (\Throwable $th) {
            // throw $th;
            toastr()->error('Có lỗi khi tạo tài khoản. Vui lòng thử lại');
            return redirect()->back();
        }
        

    }
    public function profile(){
        try {
            $user = Auth::user();
            return view('client.page.auth.profile', compact('user'));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function updateProfile(Request $request){
        $oldPassword = $request->oldpassword;
        // dd();
        $newpassword = $request->newpassword;
        if(Hash::check($oldPassword, Auth::user()->password)){
            $user = User::find(Auth::id());
            $user->password = Hash::make($newpassword);
            $user->save();
            toastr()->success('Cập nhật hồ sơ thành công');
            return redirect('/hosocuatoi');
        }
        else{
            $error = ['error' => 'Mật khẩu cũ không đúng'];
            // $error = "Mật khẩu cũ không đúng";
            return  redirect()->back()->withErrors($error)->withInput();
        }
    }
    public function addAddress(Request $request){
        try {
            $data = $request->only('name','address','phone');
            $address = new Address();
            $address->name = $data['name'];
            $address->phone = $data['phone'];
            $address->address = $data['address'];
            $address->user_id = Auth::id();
            $address->save();
            return response()->json([
                'status'=>true,
                'message'=>'Thêm địa chỉ thành công'
            ]);

        } catch (\Throwable $th) {
             return response()->json([
                'status'=>false,
                'message'=>'Có lỗi khi thêm địa chỉ',
                'error'=>$th
            ]);
        }
    }
    public function updateAddress(Request $request){
        try {

            $data = $request->only('name','address','phone','id');
            $address =  Address::find($data['id']);
            $address->name = $data['name'];
            $address->phone = $data['phone'];
            $address->address = $data['address'];
            $address->user_id = Auth::id();
            $address->save();
            return response()->json([
                'status'=>true,
                'message'=>'Sửa địa chỉ thành công'
            ]);

        } catch (\Throwable $th) {
             return response()->json([
                'status'=>false,
                'message'=>'Có lỗi khi sửa địa chỉ',
                'error'=>$th
            ]);
        }
    }
    public function removeAddress(Request $request){
        $id = $request->id;
        try {
            $address = Address::find($id);
            $address->delete();
            return response()->json([
                'status'=>true,
                'message'=>'Xóa địa chỉ thành công',
                
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>true,
                'message'=>'Có lỗi khi xóa địa chỉ',
                'error'=>$th
            ]);
        }
    }
    public function getAddress(){
        // $user = Auth::user();
        // dd(Auth::id());
        $address = Address::where('user_id',Auth::id())->get();

        $data =  '';
        foreach ($address as $key => $item) {
            $data .= '<li class="cus-radio align-items-center justify-content-between">';
            if($key == 0 ){
                $data .= '<input type="radio" name="address_rdo" value="'.$item->id.'" id="radio'.$item->id.'" checked="checked">';
            }
            else{
                $data .= '<input type="radio" name="address_rdo" value="'.$item->id.'" id="radio'.$item->id.'">';
            }
            $data.='<label for="radio'.$item->id.'">
                            <span>'.$item->name.'</span>
                            <span>'.$item->phone.'</span>
                            <span>'.$item->address.'</span>
                        </label>
                        <div>
                            <button type="button" onclick="showEditAddress(this)"
                                class="edit-address btn btn-outline-primary" data-id="'.$item->id.'" data-name="'.$item->name.'"
                                data-phone="'.$item->phone.'" data-address="'.$item->address.'">Sửa</button>
                            <button type="button" class="dlt-address btn btn-outline-primary ml-2"
                                data-id="'.$item->id.'" onclick="RemoveAddress('.$item->id.')">Xóa</button>
                        </div>
                    </li>';
        }   
    
        return response()->json($data);
    }
    
}

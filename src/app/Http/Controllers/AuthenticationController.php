<?php
namespace App\Http\Controllers;

use App\Events\WelcomeEmail;
use App\Models\Country;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class AuthenticationController extends Controller
{
    //
    public function register(Request $request){
     $countries = Country::all();
     return view('user_register',with(['countries'=>$countries]));
    }

    public function storeUser(Request $request){

        $this->validate($request,[
        'first_name'=>'required|min:5|max:10|string',
        'last_name'=>'required|min:5|max:10|string|different:first_name',
        'email'=>'required|email|unique:users,email',
        'password'=>'required|min:4',
        'mobile'=>'numeric|nullable',
        'gender'=>'required|in:Male,Female',
        'address'=>'nullable|string|max:100',
        'country'=>'required|exists:countries,id',
        'profile'=>'required|mimes:jpg,jpeg,png|max:106696'
        ]);

        $requestData = $request->except(['_token','regist']);
        $imgData = 'lv_'.rand().'.'.$request->profile->extension();
        $request->profile->move(public_path('profiles/'),$imgData);
        $requestData['password'] = Hash::make($request->password);
        $requestData['profile'] = $imgData;

        $user = User::create($requestData);
        event(new WelcomeEmail($user));
        return redirect()->route('login')->with('success','User Inserted Successfully');


    }

    public function login(Request $request){
        return view('login_user');
       }

    public function UserLogin(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required|min:4',
            ]);
        $credentials = $request->only(['email','password']);
        if(Auth::attempt($credentials)){
            switch(auth()->user()->role_id){
                case 0:
                    return redirect()->route('guest',['status'=>"101"])->withSuccess('logged in Successfully');
                    break;
                case 1:
                    return redirect()->route('admin-home',['status'=>"102"])->withSuccess('logged in Successfully');
                    break;
            }

        }else{
            return redirect()->route('login')->withSuccess('Invalid Username/password');
        }
    }

    public function forgetPassword(Request $request){
        return view('forgetPassword_user');
       }

    public function UserLogout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('index-home');
     }

     public function SendForgetUserPasswordEmail(Request $request){

        $this->validate($request,[
            'email'=>'required|email|exists:users,email',
            ]);
        $requestData=$request->except(['_token','forgot_pass_btn']);
        $requestData['token']=Str::random('30');
        PasswordReset::create($requestData);
        return redirect()->route('forget-password');

     }
}

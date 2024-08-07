<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Country;
use \App\Models\User;
class UserController extends Controller
{
    public function UserProfile(){
        $data['user']=auth()->user();
        $data['countries']= Country::all();
        return view('profile_user',['data'=>$data]);
    }

    public function UserProfileUpdate(Request $request){
       $request->validate([
        'first_name'=>'required|min:5|max:10|string',
        'last_name'=>'required|min:5|max:10|string|different:first_name',
        'email'=>'required|email|exists:users,email',
        'mobile'=>'numeric|nullable',
        'gender'=>'required|in:Male,Female',
        'address'=>'nullable|string|max:100',
        'country'=>'required|exists:countries,id',
        ]);
        
        $requestData= $request->except(['_token','_method','update']);
        $user = User::find(auth()->user()->id);
        $user->update($requestData);
        return redirect()->route('user-profile')->with('success','Profile Updated Successfully.');

    }

    public function UserProfileImageUpdate(Request $request){

        // var_dump($request->profile->getClientOriginalName());

        $this->validate($request,[
            'profile'=>'required|mimes:jpg,jpeg,png|max:106696'
            ]);

        $requestData = $request->except(['_token','regist']);
        $imgData = 'lv_'.rand().'.'.$request->profile->extension();
        $requestData['profile'] = $imgData;
        $userExistingImage =auth()->user()->profile ?? null ;

        if(file_exists(public_path('profiles/'.$userExistingImage))){
           unlink(public_path('profiles/'.$userExistingImage));
        }
        $request->profile->move(public_path('profiles/'),$imgData);
        $user =  User::find(auth()->user()->id);
        $user->update($requestData);
        return redirect()->route('user-profile')->with('success','User Profile Picture Updated Successfully.');



    }

}

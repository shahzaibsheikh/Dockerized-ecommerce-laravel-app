<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;

class admincontroller extends Controller
{
    //
    public function index(){
        
      return view('admin.index');
    }

    public function usersList(){
       $users = User::all();
      //  echo"<pre>";
      //  print_r($users[0]->full_name);
      //  die();
      return view('admin.user_list',['users'=>$users]);
    }

    public function userEdit($id){

      $data['user'] = User::find($id);
      if(empty($data)){
        return back()->with('warning','User not found');
      }
      $data['countries']= Country::all();

     return view('admin.user_profile_edit',['data'=>$data]);
   }

   public function userUpdate(Request $request,$id){
    $request->validate([
      'first_name'=>'required|min:5|max:10|string',
      'last_name'=>'required|min:5|max:10|string|different:first_name',
      'email'=>'required|email|exists:users,email',
      'mobile'=>'numeric|nullable',
      'gender'=>'required|in:Male,Female',
      'role_id'=>'required|in:0,1',
      'address'=>'nullable|string|max:100',
      'country'=>'required|exists:countries,id',
      ]);
    $requestData = $request->except(['_token','_method','update']);
    $user = User::find($id);
     if(!empty($user)){
      $user->update($requestData);
      return redirect()->route('admin-user-edit',[$id])->with('success','User Profile Updated Successfully.');
     }
     return redirect()->route('admin-user-edit',[$id])->with('danger','Something went wrong.');

   }

   public function userUpdatePicture(Request $request,$id){

    
    $this->validate($request,[
      'profile'=>'required|mimes:jpg,jpeg,png|max:106696'
      ]);

  $requestData = $request->except(['_token','regist']);
  $imgData = 'lv_'.rand().'.'.$request->profile->extension();
  $requestData['profile'] = $imgData;
  $user =  User::find($id);
  if(empty($user)){
    return redirect()->route('admin-user-edit',[$id])->with('danger','Something went wrong.');
  }
  $userExistingImage = $user->profile ?? null ;
  if(file_exists(public_path('profiles/'.$userExistingImage))){
     unlink(public_path('profiles/'.$userExistingImage));
  }
  $request->profile->move(public_path('profiles/'),$imgData);
  
  $user->update($requestData);

  return redirect()->route('admin-user-edit',[$id])->with('success','User Profile Img Updated Successfully.');

   }

   public function userUpdateStatus($id,$status=null){
    
    $user = User::find($id);
     if(!empty($user) && isset($status)){
         $user->is_active= $status;
         $user->save(); 
         return redirect()->route('admin-user-list')->with('success','User Status Updated Successfully.');
     }

     return redirect()->route('admin-user-list')->with('danger','Something went wrong.');

   }
}

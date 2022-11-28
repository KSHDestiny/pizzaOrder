<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // change password page
    public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    // change password
    public function changePassword(Request $request){
        /*
        1- all field must be filled.
        2- new password & confirm password length must be greater than 6
        3- new password & confirm password must be same
        4- client old password must be the same with database password
        5- password change
        */

        $this->passwordValidationCheck($request);
        $currentUserId = Auth::user()->id;      // win htrr tae user id ko u
        $user = User::select('password')->where('id',$currentUserId)->first();
        $dbPassword = $user->password;

        if(Hash::check($request->oldPassword, $dbPassword)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id',$currentUserId)->update($data);

            // Auth::logout(); // web.php mhr auth nat bll twrr mha use loh ya  // logout / login / register twy use loh ya
            // return redirect()->route('auth#loginPage');

            return redirect()->route('category#list')->with(['changeSuccess'=>'Password Changed']);
            // return redirect()->route('category#list');
        }
        return back()->with(['notMatch' => 'the Old Password not match, Try Again!']);
    }

    // direct admin details page
    public function details(){
        return view('admin.account.details');
    }

    // direct admin profile page
    public function edit(){
        return view('admin.account.edit');
    }

    // update Account
    public function update($id,Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        // for image
        if($request->hasFile('image')){
            // 1 old image name | check => delete | store
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image; // get old image

            if($dbImage != null){
                Storage::delete(['public/'.$dbImage]);  // delete old image
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName(); // get new image name
            $request->file('image')->storeAs('public',$fileName);   // store new image at public
            $data['image'] = $fileName; // store new image at database
        }

        User::where('id',$id)->update($data);
        return redirect()->route('admin#details')->with(['updateSuccess'=>'Admin Account Updated...']);
    }

    // admin list
    public function list(){
        $admins = User::when(request('key'),function($query){
                $query  ->orWhere('name','like','%'.request('key').'%')
                        ->orWhere('email','like','%'.request('key').'%')
                        ->orWhere('gender','like','%'.request('key').'%')
                        ->orWhere('phone','like','%'.request('key').'%')
                        ->orWhere('address','like','%'.request('key').'%');
            })
                ->where('role','admin')
                ->paginate(3);
        $admins->appends(request()->all());
        return view('admin.account.list',compact('admins'));
    }

    // delete account
    public function delete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Admin Account Deleted...']);
    }

    // change role
    public function changeRole(){
        $account = User::where('role','admin')->paginate(3);
        return view('admin.account.list',compact('account'));

        // $account = User::where('id',$id)->first();
        // return view('admin.account.changeRole',compact('account'));
    }

    // change
    public function change(Request $request){
        $updateSource = [
            'role' => $request->role
        ];
        User::where('id',$request->adminId)->update($updateSource);

        // $data = $this->requestUserData($request);
        // User::where('id',$id)->update($data);
        // return redirect()->route('admin#list');
    }

    // request user role data
    // private function requestUserData($request){
    //     return [
    //         'role' => $request->role
    //     ];
    // }

    // request user data
    private function getUserData($request){
        return [
            'name' => $request->name ,
            'email' => $request->email ,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now()
        ];
    }

    // account validation check
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|file',
            'address' => 'required'
        ])->validate();
    }

    // password validation check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6|max:10',
            'newPassword' => 'required|min:6|max:10',
            'confirmPassword' => 'required|min:6|max:10|same:newPassword'
        ])->validate();
    }
}

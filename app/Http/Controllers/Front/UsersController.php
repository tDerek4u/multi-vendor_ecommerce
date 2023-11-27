<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    //user login register page
    public function loginRegister(){
        return view('front.users.login_register');
    }
    // user register
    public function userRegister(Request $request){
        if($request->ajax()){
            $data = $request->all();
            logger($data);

            $rules = array(
                'name' => 'required',
                'email' => 'required|email|unique:admins|unique:vendors|unique:users',
                'mobile' => 'required|numeric|min:8|unique:admins|unique:vendors|unique:users',
                'password' =>
                    'required|min:6|regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/|confirmed',
                'password_confirmation' => 'required|same:password',
                'accept' => "required"
            );

            $validator = Validator::make($data,$rules);

            if($validator->fails()){
                return response()->json(['errors'=>$validator->messages()]);
            }

            //Register the user
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->mobile = $data['mobile'];
            $user->password = Hash::make($data['password']);
            $user->status = 1;
            $user->save();

            if(Auth::attempt(['email' => $data['email'] , 'password' => $data['password']])){
                $redirectTo = url('/cart');
                $name = $data['name'];
                $message = 'Welcome ! '. $name;
                return response()->json([
                    'status' => true,
                    'message' => $message,
                    'url' => $redirectTo
                ]);
            }
        }
    }

    //user logout
    public function userLogout(){
        Auth::logout();
        return redirect('/');
    }

}

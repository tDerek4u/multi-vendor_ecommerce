<?php

namespace App\Http\Controllers\Front;

use App\Models\Sms;
use App\Models\Cart;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    //user login register page
    public function loginRegister()
    {
        return view('front.users.login_register');
    }

    //user login
    public function userLogin(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $rules = array(
                'email' => 'required|email|max:100|exists:users',
                'password' => 'required',
            );

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()]);
            }

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                if (Auth::user()->status == 0) {
                    Auth::logout();

                    return response()->json([
                        'type' => 'incorrect',
                        'message' => 'Your account is inactive. Please contact Admin !'
                    ]);
                }

                //update user cart with user_id
                if (!empty(Session::get('session_id'))) {
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    Cart::where('session_id', $session_id)->update(['user_id' => $user_id]);
                }


                $redirectTo = url('/cart');
                $name = User::select('name')->where('email', $data['email'])->first();
                $message = 'Welcome ! ' . $name['name'];
                return response()->json([
                    'status' => true,
                    'message' => $message,
                    'url' => $redirectTo
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Email or Password ! '
                ]);
            }
        }
    }

    // user register
    public function userRegister(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $rules = array(
                'name' => 'required',
                'email' => 'required|email|unique:admins|unique:vendors|unique:users',
                'mobile' => 'required|numeric|min:8|unique:admins|unique:vendors|unique:users',
                'password' =>
                'required|min:6|regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/|confirmed',
                'password_confirmation' => 'required|same:password',
                'accept' => "required"
            );

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()]);
            }

            //Register the user
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->mobile = $data['mobile'];
            $user->password = Hash::make($data['password']);
            $user->status = 0;
            $user->save();

            //Activate the user only when user confirms his email account
            $email = $data['email'];
            $messageData = ['name' => $data['name'], 'email' => $data['email'], 'code' => base64_encode($data['email'])];
            Mail::send('emails.user_confirmation', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Confirm your Building Business Account !');
            });

            //redirect back user with success message
            $redirectTo = url('user/login-register');
            return response()->json([
                'status' => true,
                'url' => $redirectTo,
                'message' => 'Please confirm your email to activate your account !'
            ]);

            //Activate the user when user straight way without sending any confirmation email
            //Send register  email
            // $email = $data['email'];
            // $messageData = ['name' => $data['name'] ,'mobile' => $data['mobile'],'email' => $data['email']];
            // Mail::send('emails.register',$messageData,function($message)use($email){
            //     $message->to($email)->subject('Welcome to our Building Business Site !');
            // });

            // if(Auth::attempt(['email' => $data['email'] , 'password' => $data['password']])){
            //     $redirectTo = url('/cart');

            //     $name = $data['name'];
            //     $message = 'Welcome ! '. $name;
            //     return response()->json([
            //         'status' => true,
            //         'message' => $message,
            //         'url' => $redirectTo
            //     ]);
            // }
        }
    }

    //user confirm account
    public function confirmUser($code)
    {
        $email = base64_decode($code);

        $userCount = User::where('email', $email)->count();

        if ($userCount > 0) {
            $userDetails = User::where('email', $email)->first();
            if ($userDetails->status == 1) {
                //Redirect the user to login register page witgh error message
                return redirect('user/login-register')->with(['error_message' => 'Your account is already activated. You can login now.']);
            } else {
                User::where('email', $email)->update(['status' => 1]);

                $messageData = ['name' => $userDetails->name, 'mobile' => $userDetails->mobile, 'email' => $userDetails->email];
                Mail::send('emails.register', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Welcome to our Building Business Site !');
                });

                //Redirect the user to login register page witgh error message
                return redirect('user/login-register')->with(['success_message' => 'Your account is activated. You can login now.']);
            }
        } else {
            abort(404);
        }
    }

    //user forgot password
    public function forgotPassword(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $rules = array(
                'email' => 'required|email|exists:users',
            );

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()]);
            }


            //generate new password
            $userDetails = User::where('email', $data['email'])->first();
            $new_password = Str::random(16);

            //update new password
            User::where('email', $data['email'])->update(['password' => bcrypt($new_password)]);
            //get user details
            $userDetails = User::where('email', $data['email'])->first()->toArray();
            //send email to user
            $email = $data['email'];
            $messageData = ['name' => $userDetails['name'], 'email' => $userDetails['email'], 'password' => $new_password];
            Mail::send('emails.user_forgot_password', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('New Password - Building Business');
            });

            return response()->json(['status' => true, 'message' => 'New password sent to your registered email']);
        } else {
            return view('front.users.forgot_password');
        }
    }

    //user account details
    public function userAccount(Request $request){
        if($request->ajax()){
            $data = $request->all();

            $rules = array(
                'name' => 'required|string|max:100',
                'address' => 'required|string|max:300',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'country' => 'required|string|max:100',
                'pincode' => 'required|numeric|digits:12',
                'mobile' => 'required|numeric|digits:12',

            );

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()]);
            }

            User::where('id',Auth::user()->id)->update([
                'name' => $data['name'],
                'address' => $data['address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'country' => $data['country'],
                'pincode' => $data['pincode'],
                'mobile' => $data['mobile'],
            ]);

            //redirect back with success message
            $redirectTo = url('user/account');
            return response()->json([
                'status' => true,
                'url' => $redirectTo,
                'message' => 'Details has been updated successfully ! '
            ]);


        }else{
            $countries = Country::where('status',1)->get()->toArray();
            return view('front.users.user_account')->with(compact('countries'));
        }
    }

    //user logout
    public function userLogout()
    {
        Auth::logout();
        return redirect('/');
    }
}

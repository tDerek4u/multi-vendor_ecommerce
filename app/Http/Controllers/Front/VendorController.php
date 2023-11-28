<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\VendorsBankDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\VendorsBusinessDetail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class VendorController extends Controller
{
    public function loginRegister(){


        return view('front.vendors.login_register');
    }


    public function vendorRegister(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // logger($data);
            // echo "<pre>"; print_r($data);
            // Validate Vendor
            $rules = array(
                'name' => 'required',
                'email' => 'required|email|unique:admins|unique:vendors|unique:users',
                'mobile' => 'required|numeric|min:8|unique:admins|unique:vendors|unique:users',
                'password' =>
                    'required|min:6|regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/|confirmed',
                'password_confirmation' => 'required|same:password',
                'accept' => "required"
            );

            // $adminEmail = Admin::select('email')->where('type','superadmin')->get()->toArray();
            // if($data['email'] == $adminEmail){
            //     $message = "Invalid Email or Password ! ";
            //     Session::flash('success', __($message));
            // }

            $validator = Validator::make($data,$rules);

            if($validator->fails()){
                return Redirect::back()->withErrors($validator);
            }

            DB::beginTransaction();

            // Create Vendor Account

            // Insert the Vendor details in vendors table
            $vendor = new Vendor;
            $vendor->name = $data['name'];
            $vendor->mobile = $data['mobile'];
            $vendor->email = $data['email'];
            $vendor->status = 0;
            $vendor->save();

            $vendor_id = DB::getPdo()->lastInsertId();

            //Insert the vendor details in admins table
             //Insert the Vendor details in vendors table
             $admin = new Admin;
             $admin->type = 'vendor';
             $admin->vendor_id = $vendor_id;
             $admin->name = $data['name'];
             $admin->mobile = $data['mobile'];
             $admin->email = $data['email'];
             $admin->password = Hash::make($data['password']);
             $admin->status = 0;
             $admin->created_at = Carbon::now();
             $admin->updated_at = Carbon::now();
             $admin->save();

             $vendorBankDetails = new VendorsBankDetail;
             $vendorBankDetails->vendor_id = $vendor_id;
             $vendorBankDetails->save();

             $vendorBusinessDetails = new VendorsBusinessDetail;
             $vendorBusinessDetails->vendor_id = $vendor_id;
             $vendorBusinessDetails->save();


            // Send Confirmation Email
            $email = $data['email'];
            $messageData = [
                'email' => $data['email'],
                'name' => $data['name'],
                'code' => base64_encode($data['email'])
            ];

            Mail::send('emails.vendor_confirmation',$messageData,function($message)use($email){
                $message->to($email)->subject('Confirm your Vendor Account',$message);
            });

            DB::commit();

            // Redirect back vendor with success message
            $message = "Thanks for registering as Vendor. Please confirm your email to activate your account. ";
            Session::flash('success', __($message));

            return redirect()->back()->with('success',$message);
        }
    }

    public function confirmVendor($email){
        // Decode Vendor Email

         $email = base64_decode($email);

         // Check Vendor Email exists

         $vendorCount = Vendor::where('email',$email)->count();
         if($vendorCount > 0){
            //Vendor Email is Already activated or not

            $vendorDetails = Vendor::where('email',$email)->first();

            if($vendorDetails->confirm == "Yes"){
                $message = "Your Vendor Account is already confirmed. You can login";
            }else{
                // update confirm column to yes in both admins/vendors table to activate

                Admin::where('email',$email)->update(['confirm'=> 'Yes']);
                Vendor::where('email',$email)->update(['confirm'=> 'Yes']);

                // Send Register Email

                $messageData = [
                    'email' => $email,
                    'name' => $vendorDetails->name,
                    'code' => $vendorDetails->mobile,
                ];

                Mail::send('emails.vendor_confirmed',$messageData,function($message)use($email){
                    $message->to($email)->subject('Your Vendor Account Confirmed',$message);
                });

                // Redirect to vendor login login-register page with success message
                $message = "Your Vendor Account is confirmed. You can login and add your personal, business and bank details to activate your Vendor Account to add products";

                return redirect('vendor/login-register')->with('success_message',$message);
            }
        }else{
            abort(404);
        }


    }
}

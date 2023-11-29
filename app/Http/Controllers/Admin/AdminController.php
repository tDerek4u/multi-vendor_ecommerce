<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\VendorsBankDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\VendorsBusinessDetail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','dashboard');
        return view('admin.dashboard');
    }

    public function updateAdminPassword(Request $request){
        Session::put('page','update_admin_password');
        if($request->isMethod('POST')){
            $data = $request->all();



            $rules = array(
                'new_password' =>
                    'required|min:6|regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',

            );

            $validator = Validator::make($data,$rules);

            if($validator->fails()){
                return Redirect::back()->withErrors($validator);
            }


            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
                if($data['confirm_password'] == $data['new_password']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message','Password has been updated successfully !');
                }else{
                    return redirect()->back()->with('error_message','New Password and Confirm password does not match !');
                }

            }else{
                return redirect()->back()->with('error_message','Your current password is incorrect ');
            }
        }

        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();

        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }

    public function checkAdminPassword(Request $request){
        $data = $request->all();

        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }

    public function updateAdminDetails(Request $request){
        Session::put('page','update_admin_details');
        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'admin_name' => 'required',
                'admin_mobile' => 'required|numeric',

            ];

            $this->validate($request,$rules);

            // upload image
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    //get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'admin/images/photos/'.$imageName;
                    // Generate New Image Name
                    Image::make($image_tmp)->save($imagePath);


                }
            }else if(!empty($data['current_admin_image'])){
                $imageName = $data['current_admin_image'];

            }else{
                $imageName = "";
            }

            Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['admin_name'],'mobile'=> $data['admin_mobile'],'image'=> $imageName]);

            return redirect()->back()->with(['success_message' => 'Admin details updated successfully ']);
        }

        return view('admin.settings.update_admin_details');
    }

    public function updateVendorDetails($slug,Request $request){
        if($slug=="personal"){
            Session::put('page','update_personal_details');
            if($request->isMethod('post')){
                $data = $request->all();

                $rules = [
                    'vendor_name' => 'required',
                    'vendor_mobile' => 'required|numeric',
                ];

                $this->validate($request,$rules);

                // upload image
                if($request->hasFile('vendor_image')){
                    $image_tmp = $request->file('vendor_image');
                    if($image_tmp->isValid()){
                        //get image extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/photos/'.$imageName;
                        // Generate New Image Name
                        Image::make($image_tmp)->save($imagePath);


                    }
                }else if(!empty($data['current_vendor_image'])){
                    $imageName = $data['current_vendor_image'];

                }else{
                    $imageName = "";
                }

                Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['vendor_name'],'mobile'=> $data['vendor_mobile'],'image'=> $imageName]);

                Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->update([
                    'name'=> $data['vendor_name'],
                    'mobile' => $data['vendor_mobile'],
                    'address' => $data['vendor_address'],
                    'city' => $data['vendor_city'],
                    'country' => $data['vendor_country'],
                    'pincode' => $data['vendor_pincode']
                ]);

                 return redirect()->back()->with(['success_message' => 'Vendor details updated successfully ']);

            }

            $vendorDetails = Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();

        }else if($slug=="business"){
            Session::put('page','update_business_details');
            if($request->isMethod('post')){

                $data = $request->all();


                $rules = [
                    'shop_name' => 'required',
                    'shop_mobile' => 'required|numeric',
                    'shop_address' => 'required',
                    'address_proof' => 'required',
                    'address_proof_image' => 'required|image',
                    'shop_email' => 'required',
                    'business_license_number' => 'required',


                ];

                $this->validate($request,$rules);

                // upload image
                if($request->hasFile('address_proof_image')){
                    $image_tmp = $request->file('address_proof_image');
                    if($image_tmp->isValid()){
                        //get image extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/proofs/'.$imageName;
                        // Generate New Image Name
                        Image::make($image_tmp)->save($imagePath);


                    }
                }else if(!empty($data['current_address_proof_image'])){
                    $imageName = $data['current_address_proof_image'];

                }else{
                    $imageName = "";
                }


                VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update([
                    'shop_name'=> $data['shop_name'],
                    'shop_address' => $data['shop_address'],
                    'shop_city' => $data['shop_city'],
                    'shop_state' => $data['shop_state'],
                    'shop_country' => $data['shop_country'],
                    'shop_pincode' => $data['shop_pincode'],
                    'shop_mobile' => $data['shop_mobile'],
                    'shop_website' => $data['shop_website'],
                    'address_proof' => $data['address_proof'],
                    'business_license_number' => $data['business_license_number'],
                    'gst_number' => $data['gst_number'],
                    'pan_number' => $data['pan_number'],
                    'address_proof_image' => $imageName,


                ]);

                 return redirect()->back()->with(['success_message' => 'Shop details updated successfully ']);

            }

            $vendorDetails = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }else if($slug=="bank"){
            Session::put('page','update_bank_details');

            if($request->isMethod('post')){
                $data = $request->all();

                $rules = [
                    'account_holder_name' => 'required',
                    'bank_name' => 'required',
                    'account_number' => 'required|numeric',
                    'bank_ifsc_code' => 'required'
                ];

                $this->validate($request,$rules);


                VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update([
                    'account_holder_name'=> $data['account_holder_name'],
                    'bank_name' => $data['bank_name'],
                    'account_number' => $data['account_number'],
                    'bank_ifsc_code' => $data['bank_ifsc_code'],
                ]);

                 return redirect()->back()->with(['success_message' => 'Vendor bank details updated successfully ']);

            }

            $vendorDetails = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }

        $countries = Country::where('status',1)->get()->toArray();
        return view('admin.settings.update_vendor_details')->with(compact('slug','vendorDetails','countries'));
    }

    public function admins($type=null){
        $admins = Admin::query();
        if(!empty($type)){

            $admins = $admins->where('type',$type);
            $title = ucfirst($type)."s";
            Session::put('page','view_' .strtolower($title));
        }else{
            $title = "All Admins/Subadmins/Vendors";
            Session::put('page','viewAll');
        }
        $admins = $admins->get()->toArray();

        return view('admin.admins.admins')->with(compact('admins','title'));
    }

    public function viewVendorDetails($id){
        $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank')->where('id',$id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails),true);

        return view('admin.admins.view_vendor_details')->with(compact('vendorDetails'));
    }

    public function updateAdminStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();

            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Admin::where('id',$data['admin_id'])->update(['status' => $status]);

            $adminDetails = Admin::where('id',$data['admin_id'])->first()->toArray();

            if($adminDetails['type'] == "vendor" && $status == 1){
                Vendor::where('id',$adminDetails['vendor_id'])->update(['status' => $status]);
                // Send Confirmation Email
                $email = $adminDetails['email'];
                $messageData = [
                    'email' => $adminDetails['email'],
                    'name' => $adminDetails['name'],
                    'mobile' => $adminDetails['mobile'],
                ];

                Mail::send('emails.vendor_approved',$messageData,function($message)use($email){
                    $message->to($email)->subject('Vendor Account is Approved');
                });
            }

            return response()->json(['status' => $status,'admin_id' => $status]);
        }
    }

    public function login(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required'
            ];


            $validator = Validator::make($data,$rules);

            if($validator->fails()){
                return back()->with(['error_message' => 'Invalid Email or Password ! ']);
            }

            if(Auth::guard('admin')->attempt(
                [
                'email' => $data['email'],
                'password' => $data['password']]
                )
            ){
                if(Auth::guard('admin')->user()->type== "vendor" && Auth::guard('admin')->user()->confirm == "No"){

                    return redirect()->back()->with('error_message','Please confirm your email to activate your vendor Account');

                }else if(Auth::guard('admin')->user()->type != "vendor" && Auth::guard('admin')->user()->status == 0 ){

                    return redirect()->back()->with('error_message','Your admin account is not active');

                }else{
                    return redirect('admin/dashboard');
                }

            }else{
                return redirect()->back()->with('error_message','Invalid Email or Password');
            }
        }
        return view('admin.login');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}

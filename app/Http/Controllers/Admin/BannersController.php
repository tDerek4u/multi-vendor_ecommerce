<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Image;

class BannersController extends Controller
{
    // get banners
    public function banners(){
        Session::put('page','banners');
        $banners = Banner::get()->toArray();
        return view('admin.banners.banners')->with(compact('banners'));
    }

    //update banner status
    public function updateBannerStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();

           if($data['status'] == "Active"){
                $status = 0;
           }else{
                $status = 1;
           }
        }

        Banner::where('id',$data['banner_id'])->update(['status' => $status]);
        return response()->json(['status' => $status,'banner_id' => $status]);
    }

    public function deleteBanner($id){
        //get banner image
        $bannerImage = Banner::where('id',$id)->first();

        $banner_image_path = "front/images/banner_images/";

        //delete banner image if not exists in a folder
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }

        //Delete Banner Image from banner table
        Banner::where('id',$id)->delete();
        $message = "Banner has been deleted successfully !";

        return back()->with('success_message',$message);
    }

    //add edit banner
    public function addEditBanner(Request $request,$id = null){
        Session::put('page','banners');
        if($id == ""){
            //Add banner
            $banner = new Banner;
            $title = "Add Banner Image";
            $message = "Banner added successfully !";
        }else{
            // update bannner
            $banner = Banner::find($id);
            $title = "Update Banner Image";
            $message = "Banner updated successfully !";
        }

        if($request->isMethod('post')){
            $data = $request->all();

            $banner->type = $data['banner_type'];
           $banner->link = $data['banner_link'];
           $banner->title = $data['banner_title'];
           $banner->alt = $data['banner_alter'];
           $banner->status = 1;

           if($data['banner_type'] == "Slider"){
                $width = "1920";
                $height = "720";
           }else if($data['banner_type'] == "Fix"){
                $width = "1920";
                $height = "450";
           }

            // upload image
            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    //get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'front/images/banner_images/'.$imageName;
                    // Generate New Image Name
                    Image::make($image_tmp)->resize($width,$height)->save($imagePath);
                    $banner->image = $imageName;

                }
            }else{
                $banner->image = "";
            }
            $banner->save();

            return redirect('admin/banners')->with('success_message',$message);

        }

        return view('admin.banners.add_edit_banner')->with(compact('title','banner'));
    }

    //delete banner image
    public function deleteBannerImage($id){

        $bannerImage = Banner::select('image')->where('id',$id)->first();

       // get banner image
        $banner_image_path = "front/images/banner_images/";

        //delete banner image if file exists on banner_images folder
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }

        //delete banner image from banner table
        Banner::select('image')->where('id',$id)->delete();
        $message = "Banner Image has been deleted successfully!";

        return back()->with('success_message',$message);
    }

}

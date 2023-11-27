<?php

namespace App\Http\Controllers\Admin;


use App\Models\Brand;
use App\Models\Product;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductsImage;
use App\Models\ProductsFilter;
use App\Models\ProductsAttribute;
use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
     //get products
     public function products(){
        Session::put('page','products');

        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;

        if($adminType == 'vendor'){
            $vendorStatus = Auth::guard('admin')->user()->status;
            if($vendorStatus == 0){
                return redirect('admin/update-vendor-details/personal')->with('error_message','Your Vendor account is not approved yet. Please make sure to fill your valid personal, business and bank details');
            }
        }

        $products = Product::with(['section' => function($query){
            $query->select('id','name');
        },'category' => function($query){
            $query->select('id','category_name');
        },'brand'=> function($query){
            $query->select('id','name');
        }]);

        if($adminType == "vendor"){
            $products = $products->where('vendor_id',$vendor_id);
        }

        $products = $products->get()->toArray();
        return view('admin.products.products')->with(compact('products'));
    }

    //update product status
    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();

            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id',$data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $status,'product_id' => $status]);
        }
    }

    //add edit product
    public function addEditProduct(Request $request,$id = null){
        logger($request->all());
        Session::put('page','products');
        if($id ==""){
            $title = "Add Product";
            $product = new Product;
            $message = "Product added successfully !";
        }else{
            $title = "Edit Product";
            $product = Product::find($id);
            $message = "Product updated successfully !";
        }

        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'category_id' => 'required',
                'brand_id' => 'required',
                'product_name' => 'required',
                'product_code' => 'required|regex:/^\w+$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_weight' => 'required',
                'product_image' => 'file|max:20000',
                'product_video' => 'file|mimes:mp4,mov,ogg,qt | max:20000'
            ];

            $this->validate($request,$rules);

            //upload product image
            //small: 250x250 medium: 500x500 large: 1000x1000
            if($request->hasFile('product_image')){
                $image_tmp = $request->file('product_image');
                if($image_tmp->isValid()){
                    //upload image after Resize
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image name
                    $imageName = rand(111,99999).'.'.$extension;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    //Upload the large,Medium and Small Images after Resize
                    Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250,250)->save($smallImagePath);
                    $product->product_image = $imageName;

                }
            }

            // Upload Product Video
            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()){

                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand(111,99999).'.'.$extension;
                    $videoPath = 'front/videos/product_videos/';
                    $video_tmp->move($videoPath,$videoName);
                    $product->product_video = $videoName;
                }
            }



            //save added datd to product table
            $categoryDetails = Category::find($data['category_id']);

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $admin_id = Auth::guard('admin')->user()->id;

            if($adminType=="vendor"){
                $product_vendor_id = $vendor_id;
            }else{
                $product_vendor_id = 0;
            }

            if(!empty($data['is_featured'])){
                $product_is_featured = $data['is_featured'];
            }else{
                $product_is_featured = "No";
            }


            if(!empty($data['is_bestseller'])){
                $product_is_bestseller = $data['is_bestseller'];
            }else{
                $product_is_bestseller = "No";
            }



                 $product->section_id = $categoryDetails['section_id'];
                 $product->category_id = $data['category_id'];
                 $product->brand_id = $data['brand_id'];
                 $product->group_code = $data['group_code'];

                 $productFilters = ProductsFilter::productFilters();
                 foreach ($productFilters as $filter) {
                    $filterAvailable = ProductsFilter::filterAvailable($filter['id'],$data['category_id']);
                    if($filterAvailable == "Yes"){
                        if(isset($filter['filter_column']) && $data[$filter['filter_column']]){
                            $product->{$filter['filter_column']} = $data[$filter['filter_column']];
                        }
                    }

                 }

                 $product->admin_type = $adminType;
                 $product->admin_id = $admin_id;
                 $product->vendor_id = $product_vendor_id;
                 $product->product_name = $data['product_name'];
                 $product->product_code = $data['product_code'];
                 $product->product_color = $data['product_color'];
                 $product->product_price = $data['product_price'];
                 $product->product_discount = $data['product_discount'];
                 $product->product_weight = $data['product_weight'];
                 $product->description = $data['description'];
                 $product->meta_title = $data['meta_title'];
                 $product->meta_description = $data['meta_description'];
                 $product->meta_keywords = $data['meta_keywords'];
                 $product->is_featured = $product_is_featured;
                 $product->is_bestseller = $product_is_bestseller;
                 $product->status = 1;
                 $product->save();



            return redirect('admin/products')->with('success_message',$message);
        }



        //Get sections with categories and sub catgories
        $categories = Section::with('categories')->get()->toArray();



        //get all brands
        $brands = Brand::where('status',1)->get()->toArray();


        return view('admin.products.add_edit_product')->with(compact('title','categories','brands','product'));
    }

    //delete product image
    public function deleteProductImage($id){
        $productImage = Product::select('product_image')->where('id',$id)->first();
        // get product image path
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';

        // Delete Product small image if exists in small folder
        if(file_exists($small_image_path.$productImage->product_image)){
            unlink($small_image_path.$productImage->product_image);
        }

         // Delete Product medium image if exists in medium folder
         if(file_exists($medium_image_path.$productImage->product_image)){
            unlink($medium_image_path.$productImage->product_image);
        }

         // Delete Product large image if exists in large folder
         if(file_exists($large_image_path.$productImage->product_image)){
            unlink($large_image_path.$productImage->product_image);
        }

        // Delete Product Image from products table
        Product::where('id',$id)->update(['product_image' => null ]);

        $message = "Product Image has been deleted successfully !";

        return redirect()->back()->with('success_message',$message);
    }

    //delete video image
    public function deleteProductVideo($id){
        $productVideo = Product::select('product_video')->where('id',$id)->first();

        $product_video_path = 'front/videos/product_videos/';

        // Delete Product small image if exists in small folder
        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
        }

        // Delete Product Image from products table
        Product::where('id',$id)->update(['product_video' => null ]);

        $message = "Product Video has been deleted successfully !";

        return redirect()->back()->with('success_message',$message);
    }

    //add product attributes
    public function addAttributes(Request $request,$id){
        Session::put('page','products');
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('attributes')->find($id);

        if($request->isMethod('post')){
            $data = $request->all();

            foreach ($data['sku'] as $key => $value) {
                if(!empty($value)){

                    // SKU Duplicate Validation
                    $skuCount = ProductsAttribute::where('sku',$value)->count();
                    if($skuCount>0){
                        return back()->with('error_message','SKU already exists!');
                    }

                    // Size Duplicate Validation
                    $sizeCount = ProductsAttribute::where(['product_id' => $id,'size' => $data['size'][$key]])->count();
                    if($sizeCount>0){
                        return back()->with('error_message','Size already exists!');
                    }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }

            return redirect()->back()->with('success_message','Product Attributes has been added successfully !');
        }

        return view('admin.attributes.add_edit_attributes')->with(compact('product'));
    }

     //update product attribute status
     public function updateAttributeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();

            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsAttribute::where('id',$data['attribute_id'])->update(['status' => $status]);
            return response()->json(['status' => $status,'attribute_id' => $status]);
        }
    }

    //edit attributes
    public function editAttributes(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            foreach ($data['attributeId'] as $key => $attribute) {

                if(!empty($attribute)){
                    ProductsAttribute::where(['id' => $data['attributeId'][$key]])->update(['price' => $data['price'][$key],'stock' => $data['stock'][$key]]);
                }
            }
            return redirect()->back()->with('success_message','Product Attributes has been updated successfully !');
        }
    }

    //
    public function addImages(Request $request,$id){
        Session::put('pages','products');
        // dd($request->all());
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('images')->find($id);
        if($request->isMethod('post')){
            $data = $request->all();
            if($request->hasFile('images')){
                $images = $request->file('images');
                foreach ($images as $key => $image) {
                    //get image tmp
                    $image_tmp = Image::make($image);
                    //get image name
                    $image_name = $image->getClientOriginalName();

                    //small: 250x250 medium: 500x500 large: 1000x1000
                    //upload image after Resize
                    $extension = $image->getClientOriginalExtension();
                    //Generate New Image name
                    $imageName = $image_name.rand(111,99999).'.'.$extension;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    //Upload the large,Medium and Small Images after Resize
                    Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250,250)->save($smallImagePath);

                    $image = new ProductsImage;
                    $image->product_id = $id;
                    $image->image = $imageName;
                    $image->status = 1;
                    $image->save();
                }
            }
            return redirect()->back()->with('success_message','Product Images has been updated successfully !');

        }

        return view('admin.images.add_edit_images')->with(compact('product'));
    }

      //update image status
      public function updateImageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsImage::where('id',$data['image_id'])->update(['status' => $status]);
            return response()->json(['status' => $status,'image_id' => $status]);
        }
    }

     //delete image
     public function deleteImage($id){
        //get product image
        $productImage = ProductsImage::select('image')->where('id',$id)->first();

        //get product image paths
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';

      // Delete Product small image if exists in small folder
      if(file_exists($small_image_path.$productImage->image)){
        unlink($small_image_path.$productImage->image);
    }

     // Delete Product medium image if exists in medium folder
     if(file_exists($medium_image_path.$productImage->image)){
        unlink($medium_image_path.$productImage->image);
    }

     // Delete Product large image if exists in large folder
     if(file_exists($large_image_path.$productImage->image)){
        unlink($large_image_path.$productImage->image);
    }



    ProductsImage::where('id',$id)->delete();
    $message = "Product Image has been deleted successfully!";

        return redirect()->back()->with('success_message',$message);
    }

    //delete product
    public function deleteProduct($id){

         //get product image
         $productImage = Product::select('image')->where('id',$id)->first();
         //get product video
         $productVideo = Product::select('product_video')->where('id',$id)->first();
         //get product image paths
         $small_image_path = 'front/images/product_images/small/';
         $medium_image_path = 'front/images/product_images/medium/';
         $large_image_path = 'front/images/product_images/large/';

       // Delete Product small image if exists in small folder
       if(file_exists($small_image_path.$productImage->image)){
         unlink($small_image_path.$productImage->image);
     }

      // Delete Product medium image if exists in medium folder
      if(file_exists($medium_image_path.$productImage->image)){
         unlink($medium_image_path.$productImage->image);
     }

      // Delete Product large image if exists in large folder
      if(file_exists($large_image_path.$productImage->image)){
         unlink($large_image_path.$productImage->image);
     }

     $product_video_path = 'front/videos/product_videos/';

     // Delete Product small image if exists in small folder
     if(file_exists($product_video_path.$productVideo->product_video)){
         unlink($product_video_path.$productVideo->product_video);
     }

        Product::where('id',$id)->delete();


        $message = "Product has been deleted successfully";

        return redirect()->back()->with('success_message',$message);
    }
}

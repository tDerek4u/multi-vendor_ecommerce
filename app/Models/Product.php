<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Section;
use App\Models\Category;
use App\Models\ProductsImage;
use App\Models\ProductsAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function section(){
        return $this->belongsTo(Section::class,'section_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function attributes(){
        return $this->hasMany(ProductsAttribute::class);
    }

    public function images(){
        return $this->hasMany(ProductsImage::class);
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class,'vendor_id')->with('vendorBusinessDetails');
    }

    public static function getDiscountPrice($product_id){
        $productDetails = Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first();
        $productDetails = json_decode(json_encode($productDetails),true);
        $categoryDetails = Category::select('category_discount')->where('id',$productDetails['category_id'])->first();
        $categoryDetails = json_decode(json_encode($categoryDetails),true);

        if($productDetails['product_discount'] > 0 ){
            //if product discount is added from the admin panel
            $discounted_price = $productDetails['product_price'] - ($productDetails['product_price'] * $productDetails['product_discount']/100);


        }else if($categoryDetails['category_discount'] > 0 ){
            //if product discount is not added but category discount is added from admin panel

            $discounted_price = $productDetails['product_price'] - ($productDetails['product_price'] * $categoryDetails['category_discount']/100);

        }else{
            $discounted_price = 0;
        }

        return $discounted_price;
    }

    public static function isProductNew($product_id){
        //Get Last 3 Products
        $productIds = Product::select('id')->where('status',1)->orderby('id','desc')->limit(3)->pluck('id');
        $productIds = json_decode(json_encode($productIds),true);


        if(in_array($product_id,$productIds)){
            $isProductNew = "Yes";
        }else{
            $isProductNew = "No";
        }

        return $isProductNew;
    }

    public static function getDiscountAttributePrice($product_id,$size){
        $productAttrPrice = ProductsAttribute::where(['product_id' => $product_id,'size' => $size])->first()->toArray();

        $productDetails = Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first();
        $productDetails = json_decode(json_encode($productDetails),true);
        $categoryDetails = Category::select('category_discount')->where('id',$productDetails['category_id'])->first();
        $categoryDetails = json_decode(json_encode($categoryDetails),true);

        if($productDetails['product_discount'] > 0 ){
            //if product discount is added from the admin panel
            $final_price = $productAttrPrice['price'] - ($productAttrPrice['price'] * $productDetails['product_discount']/100);

            $discount = $productAttrPrice['price'] - $final_price;

        }else if($categoryDetails['category_discount'] > 0 ){
            //if product discount is not added but category discount is added from admin panel

            $final_price = $productAttrPrice['price'] - ($productAttrPrice['price'] * $categoryDetails['category_discount']/100);
            $discount = $productAttrPrice['price'] - $final_price;
        }else{
            $final_price = $productAttrPrice['price'];
            $discount = 0;
        }
        return array('product_price' => $productAttrPrice['price'],'final_price' => $final_price,'discount' => $discount);

    }



}

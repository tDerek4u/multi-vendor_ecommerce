<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductsFiltersValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductsFilter extends Model
{
    use HasFactory;

    public static function getFilterName($filter_id){
        $getFilterName = ProductsFilter::select('filter_name')->where('id',$filter_id)->first();

        return $getFilterName->filter_name;
    }

    public function filter_values(){
        return $this->hasMany(ProductsFiltersValue::class,'filter_id');

    }

    public static function productFilters(){
        $productFilters = ProductsFilter::with('filter_values')->where('status',1)->get()->toArray();

        return $productFilters;
    }

    public static function filterAvailable($filter_id,$category_id){
        $filterAvailable = ProductsFilter::select('cat_ids')->where(['id' => $filter_id, 'status' => 1])->first()->toArray();

        $catIdsArr = explode(",",$filterAvailable['cat_ids']);

        if(in_array($category_id,$catIdsArr)){
            $available = "Yes";
        }else{
            $available = "No";
        }

        return $available;
    }

    public static function getSizes($url){
        $categoryDetails = Category::categoryDetails($url);

        $getProductIds = Product::select('id')->whereIn('category_id',$categoryDetails['categoryIds'])->pluck('id')->toArray();

        $getProductSizes = ProductsAttribute::select('size')->whereIn('product_id',$getProductIds)->groupBy('size')->pluck('size')->toArray();

        return $getProductSizes;
    }

    public static function getColors($url){
        $categoryDetails = Category::categoryDetails($url);

        $getProductIds = Product::select('id')->whereIn('category_id',$categoryDetails['categoryIds'])->pluck('id')->toArray();

        $getProductColors = Product::select('product_color')->whereIn('id',$getProductIds)->groupBy('product_color')->pluck('product_color')->toArray();

        return $getProductColors;
    }

    public static function getBrands($url){
        $categoryDetails = Category::categoryDetails($url);

        $getBrandIds = Product::select('brand_id')->whereIn('category_id',$categoryDetails['categoryIds'])->pluck('brand_id')->toArray();


        $getProductBrands = Brand::select('id','name')->whereIn('id',$getBrandIds)->get()->toArray();

        return $getProductBrands;
    }
}

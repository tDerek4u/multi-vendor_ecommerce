<?php

namespace App\Http\Controllers\Front;

use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductsFilter;
use App\Models\ProductsAttribute;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    //listing products
    public function listing(Request $request){
        if($request->ajax()){
            $data = $request->all();
            logger($data);
            $url = $data['url'];
            $_GET['sort'] = $data['sort'];
            $categoryCount = Category::where(['url' => $url,'status' => 1])->count();
            if($categoryCount>0){
                //Get category details
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['categoryIds'])->where('status',1);

                // Checking for Dynamic Filters
                $productFilters = ProductsFilter::productFilters();
                foreach ($productFilters as $key => $filter) {
                    // if filter is selected
                    if(isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])){
                        $categoryProducts->whereIn($filter['filter_column'],$data[$filter['filter_column']]);
                    }
                }

                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort'] == "product_latest"){
                        $categoryProducts->orderBy('products.id','desc');
                    }else if($_GET['sort'] == "price_lowest"){
                        $categoryProducts->orderBy('products.product_price','asc');

                    }else if($_GET['sort'] == "price_highest"){
                        $categoryProducts->orderBy('products.product_price','desc');
                    }else if($_GET['sort'] == "name_a_z"){
                        $categoryProducts->orderBy('products.product_name','asc');
                    }else if($_GET['sort'] == "name_z_a"){
                        $categoryProducts->orderBy('products.product_name','desc');
                    }
                }

                // checking for size
                if(!empty($data['size']) && isset($data['size'])){
                    $productIds = ProductsAttribute::select('product_id')->whereIn('size',$data['size'])->pluck('product_id')->toArray();

                    $categoryProducts->whereIn('id',$productIds);
                }

                 // checking for color
                 if(!empty($data['color']) && isset($data['color'])){
                    $productIds = Product::select('id')->whereIn('product_color',$data['color'])->pluck('id')->toArray();

                    $categoryProducts->whereIn('id',$productIds);
                }

                 // checking for price
                 if(!empty($data['price']) && isset($data['price'])){
                    $implodePrices = implode('-',$data['price']);
                    $explodePrices = explode('-',$implodePrices);

                   $min = reset($explodePrices);
                   $max = end($explodePrices);

                   $productIds = Product::select('id')->whereBetween('product_price',[$min,$max])->pluck('id')->toArray();

                   $categoryProducts->whereIn('products.id',$productIds);

                }

                  // checking for brand
                 if(!empty($data['brand']) && isset($data['brand'])){
                    $productIds = Product::select('id')->whereIn('brand_id',$data['brand'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('id',$productIds);
                }

                $categoryProducts = $categoryProducts->paginate(30);
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{
                abort(404);
            }
        }else{
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url' => $url,'status' => 1])->count();
            if($categoryCount > 0){
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['categoryIds'])->where('status',1);

                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort'] == "product_latest"){
                        $categoryProducts->orderBy('products.id','desc');
                    }else if($_GET['sort'] == "price_lowest"){
                        $categoryProducts->orderBy('products.product_price','asc');

                    }else if($_GET['sort'] == "price_highest"){
                        $categoryProducts->orderBy('products.product_price','desc');
                    }else if($_GET['sort'] == "name_a_z"){
                        $categoryProducts->orderBy('products.product_name','asc');
                    }else if($_GET['sort'] == "name_z_a"){
                        $categoryProducts->orderBy('products.product_name','desc');
                    }
                }

                $categoryProducts = $categoryProducts->paginate(30);
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{
                abort(404);
            }
        }


    }

    //
    public function vendorListing($vendorid){
        //Get Vendor Details
        $getVendorShop = Vendor::getVendorShop($vendorid);

        //get yours product
        $vendorProducts = Product::with('brand')->where('vendor_id',$vendorid)->where('status',1);

        $vendorProducts = $vendorProducts->paginate(30);

        return view('front.products.vendor_listing')->with(compact('getVendorShop','vendorProducts'));
    }

    public function detail($id){
        $productDetails = Product::with(['section','category','brand','vendor','attributes' => function($query){
            $query->where('stock', '>',0)->where('status',1);
        },'images','vendor'])->find($id)->toArray();


        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);

        //get similar products
        $similarProducts = Product::with('brand')->where('category_id',$productDetails['category']['id'])->where('id', '!=',$id)->limit(4)->inRandomOrder()->get()->toArray();

        //Set session for recently Viewed products
        if(empty(Session::get('session_id'))){
            $session_id = md5(uniqid(rand(),true));

        }else{
            $session_id = Session::get('session_id');
        }

        Session::put('session_id',$session_id);

        //Insert product in table if not alrdy exists
        $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['product_id' => $id , 'session_id' => $session_id])->count();

        if($countRecentlyViewedProducts == 0){
            DB::table('recently_viewed_products')->insert(['product_id' => $id , 'session_id' => $session_id]);
        }

        //Get Recently Viewed Products ids
        $recentProductsIds = DB::table('recently_viewed_products')->select('product_id')->where('product_id', '!=' , $id)->where('session_id',$session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');

         //Get Recently Viewed Products
        $recentlyViewedProducts = Product::with('brand')->whereIn('id',$recentProductsIds)->get()->toArray();

        //get group products (Product colors)
        $groupProducts = array();
        if(!empty($productDetails['group_code'])){
            $groupProducts = Product::select('id','product_image')->where('id','!=',$id)->where(['group_code' => $productDetails['group_code'],'status' => 1])->get()->toArray();
        }

        $totalStock = ProductsAttribute::where('product_id',$id)->sum('stock');

        return view('front.products.detail')->with(compact('similarProducts','totalStock','productDetails','categoryDetails','recentlyViewedProducts','groupProducts'));
    }

    public function getProductPrice(Request $request){
        if($request->ajax()){
            $data = $request->all();


            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'],$data['size']);

            return $getDiscountAttributePrice;

        }
    }



}

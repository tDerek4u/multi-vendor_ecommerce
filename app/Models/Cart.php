<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    public static function getCartItems(){
        if(Auth::check()){
            //if user logged in / pick auth id of the user
            $getCartItems = Cart::with(['product' => function($query){
                $query->select('id','category_id','product_name','product_code','product_color','product_price','product_image');
            }])->orderBy('id','Desc')->where('user_id',Auth::user()->id)->get()->toArray();
        }else{
            //if user not logged in / picl session id
            $getCartItems = Cart::with(['product' => function($query){
                $query->select('id','category_id','product_name','product_code','product_color','product_price','product_image');
            }])->orderBy('id','Desc')->where('session_id',Session::get('session_id'))->get()->toArray();
        }

        return $getCartItems;
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}

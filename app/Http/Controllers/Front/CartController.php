<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\ProductsAttribute;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'size' => 'required',
                'quantity' => 'required|numeric|gt:0',
            ];

            $this->validate($request, $rules);

            if ($request->quantity == 0) {
                return back()->with('error_message', 'Invalid Quantity !');
            }

            $getProductStock = ProductsAttribute::isStockAvailable($data['product_id'], $data['size']);

            if ($getProductStock < $data['quantity']) {
                return back()->with('error_message', 'Required Quantity is not available!');
            }

            //Genarate Session id if is not exists
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }

            //Check product if already exists in the user cart
            if(Auth::check()){
                //User is logged in
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id' => $data['product_id'] , 'size' => $data['size'],'user_id' => $user_id])->count();
            }else{
                //User is not logged in
                $user_id = 0;
                $countProducts = Cart::where(['product_id' => $data['product_id'] , 'size' => $data['size'],'session_id' => $session_id])->count();
            }

            if($countProducts > 0){
                return redirect()->back()->with('error_message','Product already exists in Cart ! ');
            }

            //Save product in carts table
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();

            return redirect()->back()->with('success_message', 'Product has been added in Cart ! ');
        }
    }

    //view cart
    public function cart(){
        $getCartItems = Cart::getCartItems();


        return view('front.cart.cart')->with(compact('getCartItems'));
    }

    //update cart quantity item
    public function updateCart(Request $request){
        if($request->ajax()){
            $data = $request->all();

            //get cart detail
            $cartDetails = Cart::find($data['cartid']);

            //get available product stock
            $availableStock = ProductsAttribute::select('stock')->where(['product_id' => $cartDetails['product_id'],'size' => $cartDetails['size']])->first()->toArray();

            if($data['quantity'] > $availableStock['stock'] ){
                $getCartItems = Cart::getCartItems();
                Session::flash('message', __('Product Stock is not available !'));
                return response()->json([
                    'status' => false ,
                    'view' => (String)View::make('front.cart.cart_items')->with(compact('getCartItems'))
                   ]);
            }

            //check if size is available
            $availableSize = ProductsAttribute::where(['product_id' => $cartDetails['product_id'],'size' => $cartDetails['size'],'status' => 1])->count();
            if($availableSize == 0 ){
                $getCartItems = Cart::getCartItems();
                Session::flash('size_message', __('Product Size is not available ! Remove this product and choose anothe one !'));
                return response()->json([
                    'status' => false ,
                    'view' => (String)View::make('front.cart.cart_items')->with(compact('getCartItems'))
                   ]);
            }


           Cart::where('id',$data['cartid'])->update(['quantity' => $data['quantity']]);

           $getCartItems = Cart::getCartItems();

           return response()->json([
            'status' => true ,
            'view' => (String)View::make('front.cart.cart_items')->with(compact('getCartItems'))
           ]);
        }
    }

    //delete cart
    public function deleteCart(Request $request){
        if($request->ajax()){
            $data = $request->all();

            Cart::where('id',$data['cartid'])->delete();

            $getCartItems = Cart::getCartItems();

            return response()->json([
                'status' => true ,
                'view' => (String)View::make('front.cart.cart_items')->with(compact('getCartItems')),
               ]);
        }


    }
}

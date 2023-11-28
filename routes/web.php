<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\BannersController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\UsersController;
use App\Http\Controllers\Front\VendorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('/admin/')->group(function(){
    // Admin Login Route without admin group
    Route::match(['get','post'],'/login',[AdminController::class,'login']);

    Route::group(['middleware'=>['admin']],function(){
           // Admin Dashboard Route without admin group
        Route::get('/dashboard',[AdminController::class,'dashboard']);
        //Admin update password
        Route::match(['get','post'],'/update-admin-password',[AdminController::class,'updateAdminPassword']);
        //Check Admin Password
        Route::post('/check-current-password',[AdminController::class,'checkAdminPassword']);
        //Update Admin Personal Details
        Route::match(['get','post'],'update-admin-details',[AdminController::class,'updateAdminDetails']);
        //Update Vendor Details
        Route::match(['get','post'],'update-vendor-details/{slug}',[AdminController::class,'updateVendorDetails']);
        //Admins Type
        Route::get('admins/{type?}',[AdminController::class,'admins']);
        //View Vendor Details
        Route::get('view-vendor-details/{id}',[AdminController::class,'viewVendorDetails']);
        //Update Admin Status
        Route::post('update-admin-status',[AdminController::class,'updateAdminStatus']);

        //Sections
        //get section
        Route::get('sections',[SectionController::class,'sections']);
        //Update section status
        Route::post('update-section-status',[SectionController::class,'updateSectionStatus']);
        //delete section
        Route::get('delete-section/{id}',[SectionController::class,'deleteSection']);
        //section add/edit
        Route::match(['get','post'],'add-edit-section/{id?}',[SectionController::class,'addEditSection']);

        // CATEGORY
        //get category
        Route::get('categories',[CategoryController::class,'categories']);
         //delete section
        Route::get('delete-category/{id}',[CategoryController::class,'deleteCategory']);
         // category add/edit
        Route::match(['get','post'],'add-edit-category/{id?}',[CategoryController::class,'addEditCategory']);
          //Update category status
        Route::post('update-category-status',[CategoryController::class,'updateCategoryStatus']);
        //append categories level
        Route::get('append-categories-level',[CategoryController::class,'appendCategoryLevel']);
        // category image delete
        Route::get('delete-category-image/{id}',[CategoryController::class,'deleteCategoryImage']);

        //Brands
        //get brand
        Route::get('brands',[BrandController::class,'brands']);
        //Update brand status
        Route::post('update-brand-status',[BrandController::class,'updateBrandStatus']);
        //delete brand
        Route::get('delete-brand/{id}',[BrandController::class,'deleteBrand']);
        //brand add/edit
        Route::match(['get','post'],'add-edit-brand/{id?}',[BrandController::class,'addEditBrand']);

        //products
        //get products
        Route::get('products',[ProductController::class,'products']);
         //delete product
        Route::get('delete-product/{id}',[ProductController::class,'deleteProduct']);
        //Update product status
        Route::post('update-product-status',[ProductController::class,'updateProductStatus']);
        // category add/edit
        Route::match(['get','post'],'add-edit-product/{id?}',[ProductController::class,'addEditProduct']);
        // product image delete
        Route::get('delete-product-image/{id}',[ProductController::class,'deleteProductImage']);
        // product image delete
        Route::get('delete-product-video/{id}',[ProductController::class,'deleteProductVideo']);

        //Add Product Attribute
        Route::match(['get','post'],'add-edit-attributes/{id}',[ProductController::class,'addAttributes']);
         //Update product attribute status
         Route::post('update-attribute-status',[ProductController::class,'updateAttributeStatus']);
         //delete product attribute
         Route::get('delete-attribute/{id}',[ProductController::class,'deleteAttribute']);

        //  Route::match('edit-attributes/{id}',[Productcontroller::class,'editAttributes']);
         Route::match(['get','post'],'edit-attributes/{id}',[ProductController::class,'editAttributes']);


        // Filters
        Route::get('/filters',[FilterController::class,'filters']);
        Route::get('/filters-values',[FilterController::class,'filtersValues']);
        //Update filter status
        Route::post('update-filter-status',[FilterController::class,'updateFilterStatus']);
        // add edit filter
        Route::match(['get','post'],'add-edit-filter/{id?}',[FilterController::class,'addEditFilter']);
        //add edit filtervalue
        Route::match(['get','post'],'add-edit-filter-value/{id?}',[FilterController::class,'addEditFilterValue']);
         //Update filter status
         Route::post('update-filter-value-status',[FilterController::class,'updateFilterValueStatus']);
        //
         Route::post('category-filters',[FilterController::class,'categoryFilters']);



        //  Multiple Images
        Route::match(['get','post'],'add-images/{id}',[ProductController::class,'addImages']);
        // update image status
        Route::post('update-image-status',[ProductController::class,'updateImageStatus']);
        //delete image
        Route::get('delete-image/{id}',[ProductController::class,'deleteImage']);

        //Banners
        Route::get('/banners',[BannersController::class,'banners']);
         //Update banners status
         Route::post('update-banner-status',[BannersController::class,'updateBannerStatus']);
          //delete banner
          Route::get('delete-banner/{id}',[BannersController::class,'deleteBanner']);
        //add edit banner
        Route::match(['get','post'],'add-edit-banner/{id?}',[BannersController::class,'addEditBanner']);

        // Logout
        Route::get('/logout',[AdminController::class,'logout']);
    });


});


Route::namespace('App\Http\Controllers\Front')->group(function(){
    Route::get('/',[IndexController::class,'index']);

    //Listing/Categories Routes
    $categorytUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();

    foreach($categorytUrls as $key => $url){
        Route::match(['get','post'],'/'.$url,[ProductsController::class,'listing']);
    }

    //Vendor Products
    Route::get('/products/{vendorid}',[ProductsController::class,'vendorListing']);

    // Product detail page
    Route::get('/product/{id}',[ProductsController::class,'detail']);

    // Get Product Attribute Price
    Route::post('/get-product-price',[ProductsController::class,'getProductPrice']);

    // Vendor Login/Register
    Route::get('/vendor/login-register',[VendorController::class,'loginRegister']);

    // Vendor Register
    Route::post('/vendor/register',[VendorController::class,'vendorRegister']);

    // confirmation vendor account
    Route::get('vendor/confirm/{code}',[VendorController::class,'confirmVendor']);


     // User Login/Register
     Route::get('/user/login-register',[UsersController::class,'loginRegister']);

     // User Register
     Route::post('/user/register',[UsersController::class,'userRegister']);

     // confirmation User account
     Route::get('user/confirm/{code}',[UsersController::class,'confirmUser']);

     //user login
     Route::post('user/login',[UsersController::class,'userLogin']);

      //user logout
    Route::get('user/logout',[UsersController::class,'userLogout']);

    //Add to cart route
    Route::post('cart/add',[CartController::class,'addToCart']);

    //cart route
    Route::get('/cart',[CartController::class,'cart']);

    //update cart item quantity
    Route::post('cart/update',[CartController::class,'updateCart']);

    //delete cart
    Route::post('cart/delete',[CartController::class,'deleteCart']);




});


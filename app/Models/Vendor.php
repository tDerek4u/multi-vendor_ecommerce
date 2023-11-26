<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public function vendorBusinessDetails(){
        return $this->belongsTo(VendorsBusinessDetail::class,'id','vendor_id');
    }

    public static function getVendorShop($vendorid){
        $getVendorShop = VendorsBusinessDetail::select('shop_name')->where('vendor_id',$vendorid)->first()->toArray();

        return $getVendorShop['shop_name'];
    }
}
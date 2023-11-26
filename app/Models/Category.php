<?php

namespace App\Models;

use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    public function section(){
        return $this->belongsTo(Section::class,'section_id')->select('id','name');
    }

    public function parentCategory(){
        return $this->belongsTo(Category::class,'parent_id')->select('id','category_name');
    }

    public function subcategories(){
        return $this->hasMany(Category::class,'parent_id')->where('status',1);
    }

    public static function categoryDetails($url){
        $categoryDetails = Category::select('id','parent_id','category_name','url','description')->with(['subcategories' =>
        function($query){
            $query->select('id','parent_id','category_name','url');
        }])->where('url',$url)->first()->toArray();
        $categoryIds = array();
        $categoryIds [] = $categoryDetails['id'];

        if($categoryDetails['parent_id'] == 0 ){
            //Only Show Main Category in Breadcrumb
            $breadcrumbs = '<li class="is-marked">
                <a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].' </a>
            </li>';

        }else{
            //Only Show and sub category in Breadcrumb
            $parentCategory = Category::select('category_name','url')->where('id',$categoryDetails['parent_id'])->first()->toArray();
            $breadcrumbs = '<li class="has-separator">
                <a herf="'.url($categoryDetails['url']).'"> '.$parentCategory['category_name'].' </a>
            </li>
            <li class="is-marked">
                <a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].' </a>
            </li>';
        }

        foreach ($categoryDetails['subcategories'] as $key => $subcat) {
            $categoryIds [] = $subcat['id'];
        }

        $resp = array('categoryIds' => $categoryIds, 'categoryDetails' => $categoryDetails,'breadcrumbs' => $breadcrumbs);
        return $resp;
    }

    public static function getCategoryName($category_id){
        $getCategoryName = Category::select('category_name')->where('id',$category_id)->first();

        return $getCategoryName->category_name;
    }


}

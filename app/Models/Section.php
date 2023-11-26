<?php

namespace App\Models;


use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected $guarded=[];

    public static function sections(){
        $getSections = Section::with('categories')->where('status',1)->get()->toArray();
        return $getSections;
    }

    public function categories(){
        return $this->hasMany(Category::class,'section_id')->where(['parent_id' => 0,'status' => 1])->with('subcategories');
    }
}

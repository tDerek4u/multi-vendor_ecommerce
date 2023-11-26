<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class CategoryController extends Controller
{
    public function categories(){
        Session::put('page','categories');
        $categories = Category::with(['section','parentCategory'])->get()->toArray();
        return view('admin.categories.categories')->with(compact('categories'));
    }


    public function addEditCategory(Request $request,$id = null){
        Session::put('page','sections');
        if($id==""){
            $title = "Add Category";
            $category = new Category;
            $getCategories = array();
            $message = "Category added successfully!";
        }else{
            $title = "Edit Category";
            $category = Category::find($id);
            $getCategories = Category::with('subcategories')->where(['parent_id' => 0 ,'section_id' => $category['section_id']])->get();
            $message = "Category updated successfully!";
        }


        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',


            ];

            $this->validate($request,$rules);

          // upload image
            if($request->hasFile('category_image')){
                $image_tmp = $request->file('category_image');
                if($image_tmp->isValid()){
                    //get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'front/images/category_images/'.$imageName;
                    // Generate New Image Name
                    Image::make($image_tmp)->save($imagePath);
                    $category->category_image = $imageName;

                }
            }else{
                $category->category_image = "";
            }


            $category->section_id = $data['section_id'];
            $category->parent_id = $data['parent_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            return redirect('admin/categories')->with('success_message',$message);
        }



        //get all sections
        $getSections = Section::get()->toArray();

        return view('admin.categories.add_edit_category')->with(compact('title','category','getSections','getCategories'));

    }

    public function deleteCategory($id){

        $categoryImage = Category::select('category_image')->where('id',$id)->first();

        // get category image path
        $category_image_path = 'front/images/category_images';

        // delete category Image from category_images folder if exists
        if(file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }


        Category::where('id',$id)->delete();
        $message = "Category has been deleted successfully";

        return redirect()->back()->with('success_message',$message);
    }

    public function deleteCategoryImage($id){
        $categoryImage = Category::select('category_image')->where('id',$id)->first();

        // get category image path
        $category_image_path = 'front/images/category_images';

        // delete category Image from category_images folder if exists
        if(file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }

        // delete category image from categories
        Category::where('id',$id)->update(['category_image' => '']);

        $message = "Category Image has been deleted successfully !";

        return redirect()->back()->with('success_message',$message);

    }

    //update category status
    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();

            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where('id',$data['category_id'])->update(['status' => $status]);
            return response()->json(['status' => $status,'category_id' => $status]);
        }
    }

    public function appendCategoryLevel(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getCategories = Category::with('subcategories')->where(['parent_id' => 0 ,'section_id' => $data['section_id']])->get()->toArray();
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }
}

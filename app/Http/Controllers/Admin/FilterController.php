<?php

namespace App\Http\Controllers\Admin;


use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\ProductsFilter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductsFiltersValue;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class FilterController extends Controller
{
    public function filters(){
        Session::put('page','filters');

        $filters = ProductsFilter::get()->toArray();


        return view('admin.filters.filters')->with(compact('filters'));
    }

    public function filtersValues(){
        Session::put('page','filters_values');

        $filtersvalues = ProductsFiltersValue::get()->toArray();

        return view('admin.filters.filters_values')->with(compact('filtersvalues'));
    }

    //filter status
    public function updateFilterStatus(Request $request){
       if($request->ajax()){
            $data = $request->all();

            if($data['status'] == "Active"){
                $status = 0;
            }else{
                $status = 1;
            }

            ProductsFilter::where('id', $data['filter_id'])->update(['status' => $status]);
            return response()->json(['status' => $status,'filter_id' => $status]);
       }
    }

    // filter value status
    public function updateFilterValueStatus(Request $request){
        if($request->ajax()){
             $data = $request->all();

             if($data['status'] == "Active"){
                 $status = 0;
             }else{
                 $status = 1;
             }

             ProductsFiltersValue::where('id', $data['filtervalue_id'])->update(['status' => $status]);
             return response()->json(['status' => $status,'filtervalue_id' => $status]);
        }
     }

     //add edit filter
     public function addEditFilter(Request $request,$id = null){
        Session::put('page','filters');

        if($id == ""){
            $title = "Add Filter Columns";
            $filter = new ProductsFilter;
            $message = "Filter added successfully";
        }else{
            $title = "Edit Filter Columns";
            $filter = ProductsFilter::find($id);
            $message = "Filter updated successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'filter_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'filter_column' => 'required',
                'category_id' => 'required',


            ];

            $this->validate($request,$rules);

            $cat_ids = implode(',',$data['category_id']);

            // Save Filter
            $filter->cat_ids = $cat_ids;
            $filter->filter_name = $data['filter_name'];
            $filter->filter_column = $data['filter_column'];
            $filter->status = 1;
            $filter->save();

            //Add filter column in products table
            DB::statement('Alter table products add '. $data['filter_column'].' varchar(255)after description');

            return redirect('admin/filters')->with('success_message',$message);
        }

         //Get sections with categories and sub catgories
         $categories = Section::with('categories')->get()->toArray();

         return view('admin.filters.add_edit_filter')->with(compact('categories','title','filter'));



     }

    // add edit filter value
    public function addEditFilterValue(Request $request,$id = null){
        if($id == ""){
            $title = "Add Filter Value";
            $filtersvalues = new ProductsFiltersValue;
            $message = "Filter Value added successfully !";

        }else{
            $title = "Edit Filter Value";
            $filtersvalues = ProductsFiltersValue::find($id);
            $message = "Filter Value updated successfully !";

        }

        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'filter_id' => 'required',
                'filter_value' => 'required',

            ];

            $this->validate($request,$rules);

            // Save Filter value
            $filtersvalues->filter_id = $data['filter_id'];
            $filtersvalues->filter_value = $data['filter_value'];
            $filtersvalues->status = 1;
            $filtersvalues->save();

            return redirect('admin/filters-values')->with('success_message',$message);
        }

        // Get filters
        $filters = ProductsFilter::where('status',1)->get()->toArray();


         return view('admin.filters.add_edit_filters_values')->with(compact('title','filters'));
    }

    public function categoryFilters(Request $request){
        if($request->ajax()){
            $data = $request->all();

            $category_id = $data['category_id'];

            return response()->json([
                'view' => (String)View::make('admin.filters.category_filters')->with(compact('category_id'))
            ]);

        }
    }
}

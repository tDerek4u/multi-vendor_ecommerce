<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class SectionController extends Controller
{
    //Section
    public function sections(){
        Session::put('page','sections');
        $sections = Section::get()->toArray();
        return view('admin.sections.sections')->with(compact('sections'));

    }

    //update section status
    public function updateSectionStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();

            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Section::where('id',$data['section_id'])->update(['status' => $status]);
            return response()->json(['status' => $status,'section_id' => $status]);
        }
    }

    public function deleteSection($id){
        Section::where('id',$id)->delete();
        $message = "Section has been deleted successfully";

        return redirect()->back()->with('success_message',$message);
    }

    public function addEditSection(Request $request,$id = null){
        Session::put('page','sections');
        if($id==""){
            $title = "Add Section";
            $section = new Section;
            $message = "Section added successfully!";
        }else{
            $title = "Edit Section";
            $section = Section::find($id);
            $message = "Section updated successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();



            $rules = [
                'section_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];

            $this->validate($request,$rules);

            $section->name = $data['section_name'];
            $section->status = 1;
            $section->save();

            return redirect('admin/sections')->with('success_message',$message);
        }

        return view('admin.sections.add_edit_section')->with(compact('title','section'));
    }
}

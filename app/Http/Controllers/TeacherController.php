<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Carbon\Carbon;

class TeacherController extends Controller
{
    
    public function index(){
        //eloquent
        $teachers = Teacher::paginate(2);  
        return view ('admin.teacher.index',compact('teachers'));
    }
    
    // recieve id
    public function edit($id){
        $teacher = Teacher::find($id);
        return view('admin.teacher.edit',compact('teacher'));
    }

    public function store(Request $request){
        //ตรวจสอบ
        $request->validate([
            'teacher_id'=>'required|max:255',
            'teacher_name'=>'required|unique:teachers|max:255',
            'teacher_image'=>'required|mimes:jpg,jpeg,png'
        ],
        [
            'teacher_id.max' => "The teacher title must not be greater than 255 characters.",
            'teacher_image.required' => " The teacher picture field is required",
            'teacher_image.mimes' => "The teacher picture must be a file of type: jpg, jpeg, png.",
        ]
        );

        // เข้ารหัสรูป
        $teacher_image = $request->file('teacher_image');

        // generate image
        $name_gen = hexdec(uniqid());

        // ดึงนามสกุล
        $img_ext = strtolower($teacher_image->getClientOriginalExtension());
        $img_name = $name_gen. '.' .$img_ext;
        
        // upload and save
        $upload_location = 'image/teacher/';
        $full_path = $upload_location.$img_name;

        Teacher::insert([
            'teacher_id'=>$request->teacher_id,
            'teacher_name'=>$request->teacher_name,
            'teacher_image'=>$full_path,
            'created_at'=>Carbon::now()
        ]);
        $teacher_image->move($upload_location,$img_name);

        return redirect()->back()->with('success',"ข้อมูลถูกบันทึกแล้ว");
    }
    
    // back button
    public function back(){
        // $back = URL::previous();
        return redirect()->route('teacher');
    }

    // delete
    public function delete($id){
        // delete image
        $img = Teacher::find($id)->teacher_image;
        unlink($img);

        // delete data
        $delete = Teacher::find($id)->delete();
        return redirect()->back()->with('success',"ข้อมูลถูกลบแล้ว");
    }
}

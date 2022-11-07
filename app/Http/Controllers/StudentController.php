<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Carbon\Carbon;

class StudentController extends Controller
{
    
    public function index(){
        //eloquent
        $students = Student::paginate(2);  
        return view ('admin.student.index',compact('students'));
    }
    
    // recieve id
    public function edit($id){
        $student = student::find($id);
        return view('admin.student.edit',compact('student'));
    }

    public function store(Request $request){
        //ตรวจสอบ
        $request->validate([
            'student_id'=>'required|max:1',
            'student_name'=>'required|unique:students|max:255',
            'student_image'=>'required|mimes:jpg,jpeg,png'
        ],
        [
            // รหัส
            'student_id.required' => "กรุณาป้อนรหัส",
            'student_id.max' => "ห้ามป้อนเกิน 1 ตัวอักษร",
            'student_id.unique' => "รหัสนักศึกษาถูกเพิ่มไปแล้ว",
            // รูป
            'student_image.required' => "กรุณาใส่รูปภาพ",
            'student_image.mimes' => "ใช้ไฟล์สกุล jpg, jpeg, png เท่านั้น"
            
        ]
        );

        // เข้ารหัสรูป
        $student_image = $request->file('student_image');

        // generate image
        $name_gen = hexdec(uniqid());

        // ดึงนามสกุล
        $img_ext = strtolower($student_image->getClientOriginalExtension());
        $img_name = $name_gen. '.' .$img_ext;
        
        // upload and save
        $upload_location = 'image/student/';
        $full_path = $upload_location.$img_name;

        Student::insert([
            'student_id'=>$request->student_id,
            'student_name'=>$request->student_name,
            'student_image'=>$full_path,
            'created_at'=>Carbon::now()
        ]);
        $student_image->move($upload_location,$img_name);

        return redirect()->back()->with('success',"ข้อมูลถูกบันทึกแล้ว");
    }
    
    // back button
    public function back(){
        // $back = URL::previous();
        return redirect()->route('student');
    }

    // delete
    public function delete($id){
        // delete image
        $img = Student::find($id)->student_image;
        unlink($img);

        // delete data
        $delete = Student::find($id)->delete();
        return redirect()->back()->with('success',"ข้อมูลถูกลบแล้ว");
    }
}

        
        

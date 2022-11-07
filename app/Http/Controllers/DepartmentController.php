<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index(){
        //eloquent
        $departments=Department::paginate(2);
        $trashDepartments = Department::onlyTrashed()->paginate(3);
        //$departments=DB::table('departments')->get();
        return view ('admin.department.index',compact('departments','trashDepartments'));
    }

    public function store(Request $request){
        //ตรวจสอบ
        $request->validate([
            'department_name'=>'required|unique:departments|max:255'
        ],
        );
        
        //save
        // eloquent
            $department = new Department;
            $department->department_name = $request->department_name;
            $department->user_id = Auth::user()->id;
            $department->save();
        // $data = array();
        // $data["department_name"] = $request->department_name;
        // $data["user_id"] = Auth::user()->id;

        // Query Builder
        // DB::table('departments')->insert($data);

        return redirect()->back()->with('success',"ข้อมูลถูกบันทึกแล้ว");
        
    }

    public function edit($id){
        $department = Department::find($id);
        return view('admin.department.edit',compact('department'));
    }

    public function update(Request $request , $id){
        //ตรวจสอบ
        $request->validate([
            'department_name'=>'required|unique:departments|max:255'
        ],
        ['department_name.required'=>"กรุณาป้อนชื่อสาขา",
        'department_name.max'=>"ห้ามป้อนเกิน 255 ตัวอักษร",
        'department_name.unique'=>"ชื่อสาขาถูกเพิ่มไปแล้ว"
        ]
        );
        $update = Department::find($id)->update([
            'department_name'=>$request->department_name,
            'user_id'=>Auth::user()->id
        ]);

        return redirect()->route('department')->with('success',"ข้อมูลถูกบันทึกแล้ว");
    }

    public function softdelete($id){
        $delete = Department::find($id)->delete();
        return redirect()->back()->with('success',"ข้อมูลถูกลบแล้ว");
    }
    // back button
    public function back(){
        // $back = URL::previous();
        return redirect()->route('department');
    }
    // restore
    public function restore($id){
        $restore = Department::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success',"ข้อมูลกู้คืนแล้ว");
    }
    // delete
    public function delete($id){
        $delete = Department::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success',"ข้อมูลถูกลบถาวร");
    }
}

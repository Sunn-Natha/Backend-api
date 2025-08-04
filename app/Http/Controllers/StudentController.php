<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function getStudents()
    {
        $students = Student::all();
        return response()->json($students, 200);
    }
    
    public function storage(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:15',
        ]);

        if ($validation->passes()) {
            $student = Student::create($request->all());
            
            if ($student) {
                $data = [
                    'message' => 'Student created successfully',
                    'data' => $student
                ];
            } else {
                $data = [
                    'message' => 'Failed to create student',
                    'errors' => $student->getErrors()
                ];
            }
            
        } else {
            $data = [
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ];
        }
        
        return response()->json($data, 200);
    }   
    
    public function show($id){
        $student = Student::find($id);
        
        if ($student) {
            $data = [
                'message' => 'Student found',
                'data' => $student
            ];
        }else {
            $data = [
                'message' => 'Student not found',
                'data' => null
            ];
        }
        
        return response() -> json($data, 200);
    }
}

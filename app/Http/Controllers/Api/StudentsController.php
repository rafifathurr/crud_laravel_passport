<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentsResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return response([ 'employees' =>
        Student::collection($students),
        'message' => 'Successful'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_at'] = date('Y-m-d H:i:s');

        $validator = Validator::make($data, [
            'student_name' => 'required|max:255',
            'student_email' => 'email|required',
            'address' => 'required|max:255'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(),
            'Validation Error']);
        }

        $students = Student::create($data);

        return response([ 'employee' => new
        StudentsResource($students),
        'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Student $student)
    {
        return response([ 'student' => new
        StudentsResource($student), 'message' => 'Success'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $student->update($request->all());

        return response([ 'student' => new
        StudentsResource($student), 'message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return response(['message' => 'Student deleted']);
    }
}

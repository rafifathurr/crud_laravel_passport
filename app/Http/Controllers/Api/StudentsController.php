<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentsResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::paginate(10);
        return response([ 'student' =>
        $students,
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
            'address' => 'required|max:255',
            'study_course' => 'required|max:255'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(),
            'Validation Error']);
        }

        $students = Student::create($data);

        return response([ 'student' => new
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

    public function search(Request $request)
    {
        $students = Student::where('student_email', $request->student_email)
                    ->orWhere('student_name', $request->student_name)->get();
        return response([ 'student' => $students, 'message' => 'Success'], 200);
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

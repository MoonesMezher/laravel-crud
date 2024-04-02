<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreStudentRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();

        return response()->json(['students' => $students, 'status' => 'success'], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        DB::beginTransaction();

        try {
            $student = Student::create($request->only(['name', 'degree', 'subjects', 'age']));

            DB::commit();

            return response()->json(['student' => $student, 'status' => 'success'], 201);
        } catch (\Throwable $th) {
            DB::rollback();

            Log::error($th);

            return response()->json(['error' => 'An error occurred while creating this student'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return response()->json(['student' => $student,'status' => 'success'],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreStudentRequest $request, Student $student)
    {
        DB::beginTransaction();

        try {
            $student->update($request->only(['name', 'degree', 'subjects', 'age']));

            DB::commit();

            return response()->json(['student' => $student, 'status' => 'success'], 201);
        } catch (\Throwable $th) {
            DB::rollback();

            Log::error($th);

            return response()->json(['error' => 'An error occurred while creating this student'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json(['student' => $student, 'status' => 'success'], 200);
    }
}

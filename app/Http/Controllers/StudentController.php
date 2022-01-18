<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, ['perPage' => 'nullable|numeric']);

        $perPage = $request->query('perPage', 10);
        $perPage = ($perPage >= 10 && $perPage <= 500) ? $perPage : 10;

        return Student::paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'student_number' => 'required|string|min:15|max:20|unique:students',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'sex' => 'nullable|string|in:MALE,FEMALE',
            'birthdate' => 'required|date',
            'email' => 'required|email|max:255|unique:students',
            'can_vote' => 'required|boolean',
            'course_id' => 'required|numeric|exists:courses,id',
        ]);

        $student = Student::create($validated);

        return response()->json(['message' => 'Student created', 'data' => $student], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);

        return response()->json($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $this->validate($request, [
            'firstname' => 'sometimes|string|max:255',
            'lastname' => 'sometimes|string|max:255',
            'middlename' => 'sometimes|string|max:255',
            'suffix' => 'sometimes|string|max:255',
            'sex' => 'sometimes|string|in:MALE,FEMALE',
            'birthdate' => 'sometimes|date',
            'can_vote' => 'sometimes|boolean',
            'course_id' => 'sometimes|numeric|exists:courses,id',
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('students')->ignore($student->id)],
            'student_number' => [
                'sometimes',
                'string',
                'min:15',
                'max:20',
                Rule::unique('students')->ignore($student->id),
            ],
        ]);

        $student->update($validated);

        return response()->json(['message' => 'Student updated.', 'data' => $student]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        $student->delete();

        return \response('', 204);
    }
}

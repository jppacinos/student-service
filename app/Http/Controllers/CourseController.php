<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parameters = $this->validate($request, [
            's' => 'nullable|string',
        ]);

        return response()->json(
            Course::when($parameters['s'] ?? null, fn($q) => $q->where('name', 'LIKE', '%' . $parameters['s'] . '%'))
                ->orderBy('name')
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newCourse = $this->validate($request, [
            'name' => 'nullable|string|max:255',
            'acronym' => 'required|string|max:60|unique:courses',
        ]);

        $newCourse = Course::create($newCourse);

        return response()->json([
            'message' => 'Course created',
            'course' => $newCourse,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::findOrFail($id);

        return response()->json($course, 200);
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
        $course = Course::findOrFail($id);

        $newCourse = $this->validate($request, [
            'name' => 'string|max:255',
            'acronym' => ['required', 'string', 'max:60', Rule::unique('courses')->ignore($course->id)],
        ]);

        $course->update($newCourse);

        return response()->json(['message' => 'Course updated', 'course' => $course]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        if ($course->students()->count() > 0) {
            \abort(403, 'Please update or remove the students related to this course.');
        }

        $status = $course->delete();

        return response()->json(['message' => 'Course deleted', 'success' => $status]);
    }
}

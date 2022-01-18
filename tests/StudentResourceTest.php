<?php

use App\Models\Course;
use App\Models\Student;
use Laravel\Lumen\Testing\DatabaseMigrations;

class StudentResourceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $request = $this->json('GET', '/api/students?perPage=100');

        $request->response->assertOk();

        $request->seeJson([
            'current_page' => 1,
            'data' => [],
            'per_page' => '100',
            'total' => 0
        ]);
    }

    public function testStore()
    {
        $course = Course::factory()->create();

        $request = $this->json('POST', '/api/students', [
            'student_number' => '2018-15765-MN-1',
            'firstname' => 'Jhon Peter',
            'lastname' => 'Pacinos',
            'sex' => 'MALE',
            'birthdate' => '1999-06-29',
            'email' => 'jp.pacinos@gmail.com',
            'can_vote' => true,
            'course_id' => $course->id
        ]);

        $request->response->assertCreated();

        $this->seeInDatabase('students', ['student_number' => '2018-15765-MN-1']);
    }

    public function testShow()
    {
        $student = Student::factory()->create();

        $request = $this->json('GET', 'api/students/' . $student->id);

        $request->response->assertOk();

        $request->seeJson([
            'id' => $student->id,
            'student_number' => $student->student_number
        ]);
    }

    public function testUpdate()
    {
        $student = Student::factory()->create();

        $this->assertNotEquals($student->student_number, '2018-15765-MN-1');

        $request = $this->json('PATCH', 'api/students/' . $student->id, [
            'student_number' => '2018-15765-MN-1',
            'firstname' => 'qqwdsdd'
        ]);

        $request->response
            ->assertOk()
            ->assertJsonPath('data.student_number', '2018-15765-MN-1')
            ->assertJsonPath('data.firstname', 'qqwdsdd');
    }

    public function testDelete()
    {
        $student = Student::factory()->create();

        $request = $this->json('DELETE', 'api/students/' . $student->id);

        $request->response->assertNoContent();

        // soft deleted
        $this->seeInDatabase('students', [
            'id' => $student->id
        ]);
    }
}

<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $haveMiddlename = \rand(1, 10) >= 8 ? true : false;
        $haveSuffix = \rand(1, 10) == 1 ? true : false;
        $sex = \rand(1, 10) > 5 ? 'male' : 'female';

        // e.g. YYYY-00536-LQ-0
        $id = \rand(\date('Y') - 7, \date('Y'))
            . '-' . \str_pad(rand(0, 99999), 5, '0', \STR_PAD_LEFT)
            . '-LQ-0';

        $lastname = config('app.env') == 'testing' ? $this->faker->lastName() . 'Testing' : $this->faker->lastName();

        return [
            'student_number' => $id,
            'lastname' => $lastname,
            'firstname' => $this->faker->firstName($sex),
            'middlename' => $haveMiddlename ? $this->faker->lastName() : null,
            'email' => $this->faker->unique()->safeEmail(),
            'suffix' => $haveSuffix ? $this->faker->suffix() : null,
            'sex' => \strtoupper($sex),
            'birthdate' => $this->faker->date(),
            'can_vote' => true,
            'course_id' => config('app.env') == 'testing' ? Course::factory() : Course::inRandomOrder()->first()->id
        ];
    }

    public function canVote()
    {
        return $this->state(['can_vote' => true]);
    }

    public function unableToVote()
    {
        return $this->state(['can_vote' => false]);
    }
}

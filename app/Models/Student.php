<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_number',
        'firstname',
        'lastname',
        'middlename',
        'suffix',
        'sex',
        'birthdate',
        'email',
        'can_vote',
        'course_id'
    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}

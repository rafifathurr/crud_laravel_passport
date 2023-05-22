<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_name', 'student_email', 'address', 'study_course'
    ];

    protected $hidden = [
        'id',
        'student_email',
        'study_course',
        'created_at',
        'updated_at'
    ];
}

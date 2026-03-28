<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCourse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'start_date', 'end_date'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_trainings', 'course_id', 'employee_id')
                    ->withPivot('result');
    }
}

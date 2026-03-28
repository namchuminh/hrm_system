<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTraining extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'course_id', 'result'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function course()
    {
        return $this->belongsTo(TrainingCourse::class, 'course_id');
    }
}

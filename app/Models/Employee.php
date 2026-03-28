<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'dept_id', 'pos_id', 'employee_code', 'full_name', 'avatar',
        'identity_number', 'identity_date', 'identity_place', 'nationality', 'education',
        'pob', 'marital_status', 'social_insurance_number', 'tax_code', 'bank_account', 'bank_name',
        'gender', 'dob', 'phone', 'address', 'join_date', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'pos_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function salaryStructure()
    {
        return $this->hasOne(SalaryStructure::class);
    }

    public function allowances()
    {
        return $this->belongsToMany(Allowance::class, 'employee_allowances');
    }

    public function trainingCourses()
    {
        return $this->belongsToMany(TrainingCourse::class, 'employee_trainings', 'employee_id', 'course_id')
                    ->withPivot('result');
    }

    public function educationHistories()
    {
        return $this->hasMany(EducationHistory::class);
    }
}

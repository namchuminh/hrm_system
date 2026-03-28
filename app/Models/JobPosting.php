<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'department_id', 'quantity', 'deadline', 'experience_required', 'salary_range'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'job_id');
    }
}

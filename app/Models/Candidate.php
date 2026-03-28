<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['job_id', 'full_name', 'email', 'cv_path', 'status'];

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class, 'job_id');
    }
}

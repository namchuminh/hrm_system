<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationHistory extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'school', 'major', 'degree', 'year'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryStructure extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'base_salary', 'insurance_rate', 'tax_rate'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

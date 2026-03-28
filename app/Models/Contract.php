<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'contract_number', 'type', 'start_date', 'end_date', 'file_path',
        'salary_amount', 'probation_salary', 'working_time', 'allowances_text'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

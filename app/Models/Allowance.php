<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'amount'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_allowances');
    }
}

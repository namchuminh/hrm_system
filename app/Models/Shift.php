<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_time', 'end_time', 'late_threshold'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}

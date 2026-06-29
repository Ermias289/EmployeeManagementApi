<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'department_id',
        'hire_date',
        'salary',
        'job_title',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}

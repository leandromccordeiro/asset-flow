<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id', 'equipment_id', 'assignment_date', 'return_date'];
    protected $dates = ['assignment_date', 'return_date'];
    protected $casts = [
        'assignment_date' => 'date',
        'return_date' => 'date'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'description'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'cpf', 'birth_date', 'cost_center_id'];
    protected $dates = ['birth_date'];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}

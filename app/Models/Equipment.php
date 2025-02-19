<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $fillable = ['model', 'brand', 'patrimony', 'purchase_date', 'is_available'];
    protected $dates = ['purchase_date'];
    protected $casts = [
        'purchase_date' => 'date',
        'is_available' => 'boolean'
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}

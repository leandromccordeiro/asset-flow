<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GadgetModel extends Model
{
    use HasFactory;
    
    protected $fillable = ['type', 'brand', 'model'];

    public function equuipment()
    {
        return $this->hasMany(Equipment::class);
    }
}

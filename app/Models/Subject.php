<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    // (Sebenarnya subject tidak punya parent user, jadi biasanya aman. 
    // Tapi pastikan guarded = [] sudah ada).
}

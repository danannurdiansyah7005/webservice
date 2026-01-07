<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relasi ke Siswa
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke Mapel
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Relasi ke Guru
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}

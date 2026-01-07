<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    // --- TAMBAHKAN KODE DI BAWAH INI ---

    // 1. Relasi: Siswa adalah milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 2. Relasi: Siswa adalah milik satu Kelas
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
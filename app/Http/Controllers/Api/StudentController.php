<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Untuk transaksi database

class StudentController extends Controller
{
    // 1. TAMPILKAN SEMUA DATA (GET)
    public function index()
    {
        $students = Student::with(['user', 'classroom'])->get();
        return StudentResource::collection($students);
    }

    // 2. TAMBAH DATA BARU (POST)
    public function store(Request $request)
    {
        // Validasi inputan agar tidak asal-asalan
        $request->validate([
            'name' => 'required',
            'nis' => 'required|unique:students,nis',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        // Gunakan DB Transaction: Biar kalau gagal simpan siswa, user-nya juga batal dibuat (Safety)
        return DB::transaction(function () use ($request) {
            
            // A. Buat Akun User dulu
            $user = User::create([
                'name' => $request->name,
                'email' => $request->nis . '@sekolah.com', // Email otomatis dari NIS
                'password' => bcrypt('password'), // Password default
                'role' => 'siswa'
            ]);

            // B. Buat Data Siswa
            $student = Student::create([
                'user_id' => $user->id,
                'classroom_id' => $request->classroom_id,
                'nis' => $request->nis
            ]);

            return new StudentResource($student);
        });
    }

    // 3. LIHAT DETAIL 1 SISWA (GET)
    public function show($id)
    {
        $student = Student::with(['user', 'classroom'])->find($id);
        
        if (!$student) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        return new StudentResource($student);
    }

    // 4. UPDATE DATA (PUT)
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        // Update Data User (Nama)
        $student->user->update([
            'name' => $request->name ?? $student->user->name
        ]);

        // Update Data Siswa (Kelas & NIS)
        $student->update([
            'classroom_id' => $request->classroom_id ?? $student->classroom_id,
            'nis' => $request->nis ?? $student->nis
        ]);

        return new StudentResource($student);
    }

    // 5. HAPUS DATA (DELETE)
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        // Hapus User-nya (Karena 'cascade', data student juga akan ikut terhapus otomatis)
        $student->user->delete();

        return response()->json(['message' => 'Data siswa berhasil dihapus']);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Http\Resources\GradeResource;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    // 1. LIHAT SEMUA NILAI (READ LIST)
    public function index()
    {
        // Load semua relasi biar nama-namanya muncul
        $grades = Grade::with(['student.user', 'student.classroom', 'subject', 'teacher.user'])->latest()->get();
        return GradeResource::collection($grades);
    }

    // 2. INPUT NILAI BARU (CREATE)
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'score'      => 'required|numeric|min:0|max:100',
            'type'       => 'required',
        ]);

        $grade = Grade::create([
            'student_id'  => $request->student_id,
            'subject_id'  => $request->subject_id,
            'teacher_id'  => $request->teacher_id,
            'score'       => $request->score,
            'type'        => $request->type,
            'description' => $request->description
        ]);

        // Load relasi agar return JSON lengkap (ada nama siswa dll)
        $grade->load(['student.user', 'student.classroom', 'subject', 'teacher.user']);

        return new GradeResource($grade);
    }

    // 3. LIHAT DETAIL SATU NILAI (SHOW) - PENTING UNTUK EDIT
    public function show($id)
    {
        // Cari data nilai, kalau gak ada error 404
        $grade = Grade::find($id);

        if (!$grade) {
            return response()->json(['message' => 'Data nilai tidak ditemukan'], 404);
        }

        // PENTING: Load relasi relasinya
        // Tanpa ini, halaman Edit akan error saat mau menampilkan nama siswa
        $grade->load(['student.user', 'student.classroom', 'subject', 'teacher.user']);

        return new GradeResource($grade);
    }

    // 4. UPDATE NILAI (EDIT)
    public function update(Request $request, $id)
    {
        $grade = Grade::find($id);

        if (!$grade) {
            return response()->json(['message' => 'Data nilai tidak ditemukan'], 404);
        }

        // Validasi inputan edit
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'score'      => 'required|numeric|min:0|max:100',
            'type'       => 'required',
        ]);

        // Update data di database
        $grade->update([
            'student_id'  => $request->student_id,
            'subject_id'  => $request->subject_id,
            'teacher_id'  => $request->teacher_id,
            'score'       => $request->score,
            'type'        => $request->type,
            'description' => $request->description
        ]);

        // Refresh data relasi untuk respon balik
        $grade->load(['student.user', 'student.classroom', 'subject', 'teacher.user']);

        return new GradeResource($grade);
    }

    // 5. HAPUS NILAI (DESTROY)
    public function destroy($id)
    {
        $grade = Grade::find($id);

        if (!$grade) {
            return response()->json(['message' => 'Data nilai tidak ditemukan'], 404);
        }

        $grade->delete();

        return response()->json(['message' => 'Data nilai berhasil dihapus']);
    }
}
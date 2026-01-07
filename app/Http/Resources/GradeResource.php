<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
        public function toArray($request)
        {
            // Kita mengakses relasi bertingkat (Nested Relationship)
            // $this->student (Model Student) -> user (Model User) -> name
            
            return [
                'id' => $this->id,
                'student_id' => $this->student_id,
                'subject_id' => $this->subject_id,
                'teacher_id' => $this->teacher_id,
                'siswa' => $this->student->user->name, // Nama Siswa
                'nis' => $this->student->nis,
                'kelas' => $this->student->classroom->name_class,
                'mapel' => $this->subject->name_subject, // Nama Mapel
                'guru' => $this->teacher->user->name, // Nama Guru
                'tipe_nilai' => $this->type, // TUGAS, UTS, atau UAS
                'nilai' => $this->score,
                'keterangan' => $this->description,
            ];
        }
}

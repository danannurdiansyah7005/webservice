<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. BUAT DATA KELAS (Urutan ID harus sama dengan Excel Anda)
        // ID 1=X IPA 1, ID 2=X IPA 2, dst.
        $kelas = [
            'VII A',  // ID 1
            'VII B',  // ID 2
            'VII C',  // ID 3
            'VIII A', // ID 4
            'VIII B', // ID 5
            'VIII C', // ID 6
            'IX A',   // ID 7
            'IX B',   // ID 8
            'IX C'    // ID 9
        ];
        foreach ($kelas as $k) {
            Classroom::create(['name_class' => $k]);
        }

        // 2. BUAT DATA MAPEL
        $mapel = ['Matematika', 'Bahasa Indonesia', 'Fisika', 'Kimia', 'Biologi'];
        foreach ($mapel as $m) {
            Subject::create(['name_subject' => $m]);
        }

        // 3. BUAT AKUN GURU ADMIN
        $guru = User::create([
            'name' => 'Admin Guru',
            'email' => 'admin@guru.com',
            'password' => bcrypt('password'),
            'role' => 'guru'
        ]);
        Teacher::create(['user_id' => $guru->id, 'nip' => '19800000']);

        // 4. IMPORT DATA SISWA DARI CSV
        $path = database_path('data/data_siswa.csv');
        
        if (!file_exists($path)) {
            $this->command->error("File CSV tidak ditemukan di: " . $path);
            return;
        }

        // Membuka file CSV
        $file_handle = fopen($path, 'r');
        
        while (($row = fgetcsv($file_handle, 2000, ",")) !== FALSE) {
            // Pastikan baris tidak kosong
            if (empty($row[0])) continue;

            // $row[0] = Nama Siswa
            // $row[1] = NIS
            // $row[2] = ID Kelas (Angka)

            // A. Buat User Login (Password: password)
            $userSiswa = User::create([
                'name' => $row[0],
                // Email pakai NIS@sekolah.com agar unik
                'email' => $row[1] . '@sekolah.go.id', 
                'password' => bcrypt('password'),
                'role' => 'siswa'
            ]);

            // B. Masukkan ke Tabel Siswa
            Student::create([
                'user_id' => $userSiswa->id,
                'classroom_id' => $row[2], 
                'nis' => $row[1],
            ]);
        }

        fclose($file_handle);
    }
}
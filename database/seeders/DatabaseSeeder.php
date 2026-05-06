<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Demo teacher + students
        $teacher = User::factory()->create([
            'name' => 'Demo Teacher',
            'email' => 'teacher@example.com',
            'role' => 'teacher',
        ]);

        $students = User::factory()->count(5)->state([ 'role' => 'student', 'classroom' => '5A' ])->create();

        // create sample attendance records for today
        foreach ($students as $i => $s) {
            \App\Models\Attendance::create([
                'student_id' => $s->id,
                'teacher_id' => $teacher->id,
                'date' => now()->toDateString(),
                'status' => $i % 2 === 0 ? 'present' : 'absent',
                'classroom' => '5A',
            ]);
        }
    }
}

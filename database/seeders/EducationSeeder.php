<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        Education::updateOrCreate(
            ['school_name' => 'University', 'degree' => 'Bachelor of Computer Science'],
            [
                'field' => 'Computer Science',
                'start_year' => 2023,
                'end_year' => 2027,
                'description' => 'Studying software engineering, databases, and web development.',
            ],
        );
    }
}

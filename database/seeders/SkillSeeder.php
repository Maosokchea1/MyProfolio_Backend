<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            [
                'name' => 'HTML',
                'percentage' => 90,
                'category' => 'Frontend',
                'sort_order' => 1,
            ],
            [
                'name' => 'CSS',
                'percentage' => 85,
                'category' => 'Frontend',
                'sort_order' => 2,
            ],
            [
                'name' => 'JavaScript',
                'percentage' => 80,
                'category' => 'Frontend',
                'sort_order' => 3,
            ],
            [
                'name' => 'React',
                'percentage' => 75,
                'category' => 'Frontend',
                'sort_order' => 4,
            ],
            [
                'name' => 'PHP',
                'percentage' => 80,
                'category' => 'Backend',
                'sort_order' => 5,
            ],
            [
                'name' => 'Laravel',
                'percentage' => 80,
                'category' => 'Backend',
                'sort_order' => 6,
            ],
            [
                'name' => 'MySQL',
                'percentage' => 85,
                'category' => 'Database',
                'sort_order' => 7,
            ],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(['name' => $skill['name']], $skill);
        }
    }
}

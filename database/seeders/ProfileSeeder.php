<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::updateOrCreate(
            ['email' => 'mao.sokchea@example.com'],
            [
                'full_name' => 'Mao Sokchea',
                'title' => 'Full Stack Developer',
                'description' => 'Software developer and Computer Science student focused on React, Laravel, C#, SQL Server and MySQL.',
                'address' => 'Cambodia',
            ],
        );
    }
}

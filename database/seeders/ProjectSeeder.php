<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::updateOrCreate(
            ['slug' => 'inventory-management-system'],
            [
                'title' => 'Inventory Management System',
                'description' => 'Inventory system developed with Laravel and React.',
                'image' => 'projects/inventory.png',
                'technology' => 'React, Laravel, MySQL, Tailwind CSS',
                'github_url' => 'https://github.com/',
                'demo_url' => null,
                'status' => 'published',
                'featured' => true,
                'sort_order' => 1,
            ],
        );

        Project::updateOrCreate(
            ['slug' => 'product-store-system'],
            [
                'title' => 'Product Store System',
                'description' => 'Product management system developed with C# and SQL Server.',
                'image' => 'projects/product-store.png',
                'technology' => 'C#, Windows Forms, SQL Server',
                'github_url' => 'https://github.com/',
                'demo_url' => null,
                'status' => 'published',
                'featured' => true,
                'sort_order' => 2,
            ],
        );
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                ['label' => 'Projects', 'value' => Project::count(), 'color' => 'blue', 'icon' => '⌘'],
                ['label' => 'Skills', 'value' => Skill::count(), 'color' => 'violet', 'icon' => '◇'],
                ['label' => 'Services', 'value' => Service::count(), 'color' => 'blue', 'icon' => '◆'],
                ['label' => 'Education', 'value' => Education::count(), 'color' => 'amber', 'icon' => '▤'],
                ['label' => 'Experience', 'value' => Experience::count(), 'color' => 'violet', 'icon' => '▣'],
                ['label' => 'Messages', 'value' => Contact::count(), 'color' => 'emerald', 'icon' => '✉'],
            ],
            'profile' => Profile::query()->first(),
            'recentProjects' => Project::query()->latest()->limit(5)->get(),
            'recentContacts' => Contact::query()->latest()->limit(5)->get(),
        ]);
    }
}

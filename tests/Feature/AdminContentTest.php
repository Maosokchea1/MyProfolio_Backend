<?php

namespace Tests\Feature;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_skills_education_and_experience(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/admin/content/projects', [
            'title' => 'Portfolio Website',
            'slug' => 'portfolio-website',
            'description' => 'A full stack portfolio.',
            'technology' => 'React, Laravel',
            'status' => 'published',
            'featured' => '1',
            'sort_order' => 1,
        ])->assertRedirect('/admin/content/projects');
        $this->assertDatabaseHas('projects', [
            'slug' => 'portfolio-website',
            'status' => 'published',
            'featured' => true,
        ]);

        $this->post('/admin/content/skills', [
            'name' => 'Laravel',
            'category' => 'Backend',
            'percentage' => 90,
            'sort_order' => 1,
        ])->assertRedirect('/admin/content/skills');

        $skill = Skill::firstOrFail();
        $this->put("/admin/content/skills/{$skill->id}", [
            'name' => 'Laravel',
            'category' => 'Backend',
            'percentage' => 95,
            'sort_order' => 1,
        ])->assertRedirect('/admin/content/skills');
        $this->assertDatabaseHas('skills', ['id' => $skill->id, 'percentage' => 95]);

        $this->post('/admin/content/services', [
            'name' => 'Web Development',
            'description' => 'Full stack website development.',
            'sort_order' => 1,
            'active' => '1',
        ])->assertRedirect('/admin/content/services');
        $this->assertDatabaseHas('services', [
            'name' => 'Web Development',
            'active' => true,
        ]);

        $this->post('/admin/content/educations', [
            'school_name' => 'Royal University',
            'degree' => 'Bachelor',
            'field' => 'Computer Science',
            'start_year' => 2023,
            'end_year' => 2027,
        ])->assertRedirect('/admin/content/educations');
        $this->assertDatabaseHas('educations', ['school_name' => 'Royal University']);

        $this->post('/admin/content/experiences', [
            'company_name' => 'OpenAI',
            'position' => 'Developer',
            'start_date' => '2026-01-01',
            'currently_working' => '1',
        ])->assertRedirect('/admin/content/experiences');
        $this->assertDatabaseHas('experiences', [
            'company_name' => 'OpenAI',
            'currently_working' => true,
            'end_date' => null,
        ]);

        $education = Education::firstOrFail();
        $this->delete("/admin/content/educations/{$education->id}")
            ->assertRedirect('/admin/content/educations');
        $this->assertDatabaseMissing('educations', ['id' => $education->id]);

        $this->get('/admin/content/skills')->assertOk()->assertSee('Laravel');
        $this->get('/admin/content/experiences')->assertOk()->assertSee('OpenAI');
        $this->get('/admin/content/services')->assertOk()->assertSee('Web Development');
        $this->get('/admin/content/projects')->assertOk()->assertSee('Portfolio Website');
        $this->assertSame(1, Experience::count());
        $this->assertSame(1, Service::count());
        $this->assertSame(1, Project::count());
    }

    public function test_guests_cannot_manage_content(): void
    {
        $this->get('/admin/content/skills')->assertRedirect(route('admin.login'));
    }
}

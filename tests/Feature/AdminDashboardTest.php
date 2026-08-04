<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_sent_to_admin_login(): void
    {
        $this->get('/')->assertRedirect(route('admin.login'));
        $this->get('/admin/dashboard')->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_login_and_open_dashboard(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Portfolio Admin')
            ->assertSee('Recent Projects');
    }

    public function test_new_admin_can_register(): void
    {
        $response = $this->post('/admin/register', [
            'name' => 'New Admin',
            'email' => 'new-admin@example.com',
            'password' => 'secure-password',
            'password_confirmation' => 'secure-password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'New Admin',
            'email' => 'new-admin@example.com',
        ]);
    }

    public function test_registration_requires_unique_email_and_confirmed_password(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->from('/admin/register')->post('/admin/register', [
            'name' => 'New Admin',
            'email' => 'taken@example.com',
            'password' => 'secure-password',
            'password_confirmation' => 'different-password',
        ])
            ->assertRedirect('/admin/register')
            ->assertSessionHasErrors(['email', 'password']);
    }

    public function test_admin_can_update_about_information(): void
    {
        $this->actingAs(User::factory()->create());

        $this->put('/admin/about', [
            'full_name' => 'Mao Sokchea',
            'title' => 'Full Stack Developer',
            'description' => 'Updated portfolio about information.',
            'email' => 'mao@example.com',
        ])->assertRedirect();

        $this->assertDatabaseHas('profiles', [
            'full_name' => 'Mao Sokchea',
            'title' => 'Full Stack Developer',
        ]);

        $this->get('/admin/about')->assertOk()->assertSee('Edit About Information');
    }

    public function test_admin_can_use_uploads_or_urls_for_profile_image_and_cv(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());

        $this->put('/admin/about', [
            'full_name' => 'Mao Sokchea',
            'profile_image_url' => 'https://example.com/profile.jpg',
            'cv_url' => 'https://example.com/cv.pdf',
        ])->assertRedirect();

        $this->assertDatabaseHas('profiles', [
            'profile_image' => 'https://example.com/profile.jpg',
            'cv_file' => 'https://example.com/cv.pdf',
        ]);

        $this->put('/admin/about', [
            'full_name' => 'Mao Sokchea',
            'profile_image_upload' => new UploadedFile(
                public_path('images/logo.png'),
                'profile.png',
                'image/png',
                null,
                true,
            ),
            'cv_upload' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
        ])->assertRedirect();

        $profile = \App\Models\Profile::firstOrFail();
        Storage::disk('public')->assertExists($profile->profile_image);
        Storage::disk('public')->assertExists($profile->cv_file);
    }

    public function test_admin_can_manage_contact_messages(): void
    {
        $this->actingAs(User::factory()->create());
        $contact = Contact::create([
            'name' => 'Visitor',
            'email' => 'visitor@example.com',
            'subject' => 'Hello',
            'message' => 'Portfolio message',
        ]);

        $this->get('/admin/contacts')->assertOk()->assertSee('Portfolio message');
        $this->patch("/admin/contacts/{$contact->id}", ['status' => 'read'])
            ->assertRedirect();
        $this->assertDatabaseHas('contacts', ['id' => $contact->id, 'status' => 'read']);

        $this->delete("/admin/contacts/{$contact->id}")->assertRedirect();
        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PortfolioApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_portfolio_endpoints_return_json(): void
    {
        foreach (['/api/profile', '/api/projects', '/api/skills', '/api/services', '/api/educations', '/api/experiences'] as $url) {
            $this->getJson($url)
                ->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonStructure(['success', 'data']);
        }
    }

    public function test_contact_message_can_be_submitted(): void
    {
        $response = $this->postJson('/api/contacts', [
            'name' => 'API Test',
            'email' => 'test@example.com',
            'subject' => 'Test message',
            'message' => 'This verifies the portfolio contact API.',
        ]);

        $response->assertCreated()->assertJsonPath('success', true);
    }

    public function test_contact_message_is_forwarded_to_telegram_when_configured(): void
    {
        config([
            'services.telegram.bot_token' => 'test-token',
            'services.telegram.chat_id' => '123456789',
        ]);

        Http::fake([
            'api.telegram.org/*' => Http::response(['ok' => true, 'result' => []]),
        ]);

        $this->postJson('/api/contacts', [
            'name' => 'Telegram Test',
            'email' => 'telegram@example.com',
            'subject' => 'Portfolio enquiry',
            'message' => 'Please send this message to Telegram.',
        ])
            ->assertCreated()
            ->assertJsonPath('telegram_sent', true);

        Http::assertSent(fn (Request $request) => $request->url() ===
            'https://api.telegram.org/bottest-token/sendMessage'
            && $request['chat_id'] === '123456789'
            && str_contains($request['text'], 'Telegram Test'));
    }
}

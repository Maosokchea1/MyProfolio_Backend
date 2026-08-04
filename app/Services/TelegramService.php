<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TelegramService
{
    public function isConfigured(): bool
    {
        return filled(config('services.telegram.bot_token'))
            && filled(config('services.telegram.chat_id'));
    }

    public function sendContact(Contact $contact): bool
    {
        if (! $this->isConfigured()) {
            return false;
        }

        $text = implode("\n", [
            'New portfolio contact',
            '',
            'Name: '.$contact->name,
            'Email: '.$contact->email,
            'Subject: '.($contact->subject ?: 'No subject'),
            '',
            'Message:',
            Str::limit($contact->message, 3500),
        ]);

        try {
            $response = Http::asForm()
                ->timeout(10)
                ->post(
                    'https://api.telegram.org/bot'.config('services.telegram.bot_token').'/sendMessage',
                    [
                        'chat_id' => config('services.telegram.chat_id'),
                        'text' => $text,
                    ],
                );

            if (! $response->successful() || ! $response->json('ok')) {
                Log::warning('Telegram contact notification failed.', [
                    'status' => $response->status(),
                    'response' => $response->json(),
                ]);

                return false;
            }

            return true;
        } catch (\Throwable $exception) {
            Log::warning('Telegram contact notification failed.', [
                'message' => $exception->getMessage(),
            ]);

            return false;
        }
    }
}

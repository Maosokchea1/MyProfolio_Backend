<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Services\TelegramService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request, TelegramService $telegram): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'subject' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $contact = Contact::create($validated);
        $telegramSent = $telegram->sendContact($contact);

        return response()->json([
            'success' => true,
            'message' => $telegramSent
                ? 'Your message was sent to Telegram successfully.'
                : 'Your message was received successfully.',
            'telegram_sent' => $telegramSent,
            'data' => $contact,
        ], 201);
    }
}

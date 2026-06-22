<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class AiChatController extends Controller
{
    public function ask(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'history' => ['nullable', 'array', 'max:10'],
            'history.*.role' => ['required_with:history', 'string', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string', 'max:2000'],
        ]);

        $token = config('services.huggingface.token');

        if (! $token) {
            return response()->json([
                'message' => 'AI belum aktif. Tambahkan HF_TOKEN di file .env terlebih dahulu.',
            ], 503);
        }

        $messages = [
            [
                'role' => 'system',
                'content' => 'Kamu adalah asisten AI umum di aplikasi STUDEE. Jawab pertanyaan umum dengan jelas, singkat, ramah, dan pakai bahasa yang digunakan pengguna. Jangan mengaku bisa melihat data pribadi, tugas, file, atau akun pengguna.',
            ],
        ];

        foreach (array_slice($validated['history'] ?? [], -8) as $item) {
            $messages[] = [
                'role' => $item['role'],
                'content' => $item['content'],
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $validated['message'],
        ];

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->timeout(45)
                ->retry(2, 500)
                ->post(rtrim(config('services.huggingface.base_url'), '/') . '/chat/completions', [
                    'model' => config('services.huggingface.model'),
                    'messages' => $messages,
                    'temperature' => 0.7,
                    'max_tokens' => 600,
                ]);

            if ($response->failed()) {
                Log::warning('Hugging Face chat request failed', [
                    'status' => $response->status(),
                    'body' => $response->json() ?: $response->body(),
                ]);

                return response()->json([
                    'message' => 'AI sedang tidak bisa menjawab. Coba lagi beberapa saat.',
                ], 502);
            }

            $answer = data_get($response->json(), 'choices.0.message.content');

            if (! is_string($answer) || trim($answer) === '') {
                return response()->json([
                    'message' => 'AI mengirim respons kosong. Coba ulangi pertanyaannya.',
                ], 502);
            }

            return response()->json([
                'answer' => trim($answer),
            ]);
        } catch (Throwable $exception) {
            Log::error('Hugging Face chat request error', [
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' => 'Koneksi ke AI bermasalah. Coba lagi nanti.',
            ], 502);
        }
    }
}

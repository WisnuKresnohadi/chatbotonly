<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class EmbeddingController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Fungsi untuk memberikan tag [POS], [NEG], atau [MID] secara otomatis
     * berdasarkan kata kunci pada jawaban pengguna.
     */
    private function autoTagConfidence(string $text): string
    {
        $textLower = strtolower($text);

        $posKeywords = [
            'sangat', 'selalu'
        ];

        $negKeywords = [
             'kurang', 'agak', 'lumayan', 'cenderung', 'sedikit', 'setidaknya'
        ];
        $vnegKeywords = [
            'tidak', 'menolak', 'langsung'
        ];

        foreach ($posKeywords as $keyword) {
            if (str_contains($textLower, $keyword)) {
                return '[POS] ' . $text;
            }
        }

        foreach ($negKeywords as $keyword) {
            if (str_contains($textLower, $keyword)) {
                return '[NEG] ' . $text;
            }
        }
        foreach ($vnegKeywords as $keyword) {
            if (str_contains($textLower, $keyword)) {
                return '[VNEG] ' . $text;
            }
        }


        return '[NEU] ' . $text;
    }

    /**
     * Embed jawaban pengguna menggunakan OpenAI Embedding API.
     */
    public function embedAnswer(Request $request): JsonResponse
    {
        try {
            $originalAnswer = $request->input('answer');

            if (empty($originalAnswer)) {
                return response()->json(['error' => 'Input answer cannot be empty.'], 400);
            }

            $taggedAnswer = $this->autoTagConfidence($originalAnswer);

            $response = $this->client->post('embeddings', [
                'json' => [
                    'input' => $taggedAnswer,
                    'model' => 'text-embedding-3-small',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['data'][0]['embedding'])) {
                return response()->json(['error' => 'Invalid API response.'], 500);
            }

            return response()->json([
                'embedding' => $data['data'][0]['embedding'],
                'tagged_input' => $taggedAnswer,
            ]);

        } catch (\Exception $e) {
            Log::error('Error embedding answer:', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Failed to generate embedding.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}

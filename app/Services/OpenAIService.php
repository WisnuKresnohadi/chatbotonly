<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $client;
    protected $apiKey;
    protected $maxRetries = 5;
    protected $retryDelay = 500;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPENAI_API_KEY');
    }

    private function requestWithRetry(array $options)
    {
        $attempt = 0;

        while ($attempt < $this->maxRetries) {
            try {
                $attempt++;
                return $this->client->post('https://api.openai.com/v1/chat/completions', $options);
            } catch (\Exception $e) {
                Log::warning("OpenAI API attempt {$attempt} failed: " . $e->getMessage());

                if ($attempt >= $this->maxRetries) {
                    throw $e; // throw last error
                }

                // exponential backoff (500ms, 1000ms, 2000ms...)
                usleep($this->retryDelay * 1000 * $attempt);
            }
        }
    }

    public function getNextQuestion(string $answer, string $question): string
    {
        try {
            $response = $this->requestWithRetry([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => "You are an interview chatbot. Based on the user's answer, generate insightful follow-up questions to continue the interview. The interview question is: {$question}. Make sure you only RETURN 1 QUESTION."
                        ],
                        [
                            'role' => 'user',
                            'content' => $answer
                        ],
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return $data['choices'][0]['message']['content'] ?? "Sorry, I have no follow-up questions.";
        } catch (\Exception $error) {
            Log::error("Error in OpenAI API:", ['error' => $error->getMessage()]);
            return "Error processing the answer: " . $error->getMessage();
        }
    }

    public function conclude(array $chatHistory): string
    {
        try {
            $userAnswers = array_map(function ($message) {
                return $message['text'];
            }, array_filter($chatHistory, fn ($message) => $message['sender'] === 'user'));

            $response = $this->requestWithRetry([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => "Kamu adalah asisten AI yang bertugas menyimpulkan jawaban dari percakapan wawancara. Fokus pada jawaban yang diberikan oleh pengguna (sender: 'user') dan abaikan pertanyaan follow-up. Berikan kesimpulan yang singkat dan relevan."
                        ],
                        [
                            'role' => 'user',
                            'content' => "Berikut adalah percakapan:\n" . json_encode($userAnswers) . "\n\nTolong simpulkan jawaban berdasarkan konteks pertanyaan yang diajukan."
                        ],
                    ],
                    'temperature' => 0.5,
                    'max_tokens' => 150,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            return $data['choices'][0]['message']['content'] ?? "Unable to generate a conclusion.";
        } catch (\Exception $error) {
            Log::error("Error generating conclusion:", ['error' => $error->getMessage()]);
            return "Error in generating conclusion.";
        }
    }

    public function score(string $kriteria, string $jawaban, string $question): int
    {
        try {
            $response = $this->requestWithRetry([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'ft:gpt-4o-mini-2024-07-18:talentern:datasetv1fix:AymXOYQx',
                    'messages' => [
                        ['role' => 'system', 'content' => "Kriteria: $kriteria\nPertanyaan: $question"],
                        ['role' => 'user', 'content' => $jawaban],
                    ],
                    'temperature' => 0,
                    'top_p' => 1,
                    'max_tokens' => 10,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $totalScoreString = trim($data['choices'][0]['message']['content'] ?? "0");

            return is_numeric($totalScoreString) ? min(9, max(0, (int) $totalScoreString)) : 0;
        } catch (\Exception $error) {
            Log::error("Error scoring:", ['error' => $error->getMessage()]);
            return 0;
        }
    }

    public function scoreSoftskills(string $kriteria, string $question, string $jawaban): int
    {
        try {
            $response = $this->requestWithRetry([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'ft:gpt-4o-mini-2024-07-18:talentern:datasetv1fix:AymXOYQx',
                    'messages' => [
                        ['role' => 'system', 'content' => "Kriteria: $kriteria\nPertanyaan: $question"],
                        ['role' => 'user', 'content' => $jawaban],
                    ],
                    'temperature' => 0,
                    'top_p' => 1,
                    'max_tokens' => 10,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $totalScoreString = trim($data['choices'][0]['message']['content'] ?? "0");

            return is_numeric($totalScoreString) ? min(9, max(0, (int) $totalScoreString)) : 0;
        } catch (\Exception $error) {
            Log::error("Error in soft skills scoring:", ['error' => $error->getMessage()]);
            return 0;
        }
    }
}

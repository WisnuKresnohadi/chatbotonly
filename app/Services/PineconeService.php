<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;


namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PineconeService
{
    private $client;
    private $baseUrl;
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('PINECONE_API_KEY');
        $this->baseUrl = "https://labeltest-bu3axk2.svc.aped-4627-b74a.pinecone.io"; // Ganti dengan URL Pinecone Anda
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Api-Key' => $this->apiKey,
            ]
        ]);
    }

    /**
     * Query Pinecone untuk mencari jawaban berdasarkan vektor, pertanyaan, dan kriteria.
     */
    public function searchData(array $vector, string $question, string $kriteria)
    {
        try {
            $payload = [
                'vector' => $vector,
                'topK' => 1,
                'includeMetadata' => true,
                'namespace' => 'ns1',
                'filter' => [
                    'question' => ['$eq' => $question],
                    'kriteria' => ['$eq' => $kriteria],
                ]
            ];

            $response = $this->client->post($this->baseUrl . "/query", [
                'json' => $payload,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!empty($data['matches'])) {
                $bestMatch = $data['matches'][0];
                return [
                    'metadata' => $bestMatch['metadata'] ?? null,
                    'score' => $bestMatch['score'] ?? 0,
                ];
            }

            return [
                'metadata' => 'not found',
                'score' => 0,
            ];
        } catch (\Exception $e) {
            Log::error("Error querying Pinecone:", ['error' => $e->getMessage()]);
            return [
                'error' => 'Failed to fetch search data.',
            ];
        }
    }
}


// class PineconeService
// {
//     private $client;
//     private $baseUrl;
//     private $apiKey;
//     private $contradictionWords = ['tidak', 'bukan', 'batal', 'tanpa', 'jangan', 'mustahil', 'belum'];

//     public function __construct()
//     {
//         $this->apiKey = env('PINECONE_API_KEY');
//         $this->baseUrl = "https://useranswerfinal-bu3axk2.svc.aped-4627-b74a.pinecone.io"; // Ganti dengan URL Pinecone Anda
//         $this->client = new Client([
//             'headers' => [
//                 'Content-Type' => 'application/json',
//                 'Api-Key' => $this->apiKey,
//             ]
//         ]);
//     }

//     /**
//      * Query Pinecone untuk mencari jawaban berdasarkan vektor, pertanyaan, dan kriteria.
//      */
//     public function searchData(array $vector, string $question, string $kriteria, string $userAnswer)
//     {
//         try {
//             $payload = [
//                 'vector' => $vector,
//                 'topK' => 3, // Ambil lebih dari 1 agar ada perbandingan sebelum filtering
//                 'includeMetadata' => true,
//                 'namespace' => 'ns1',
//                 'filter' => [
//                     'question' => ['$eq' => $question],
//                     'kriteria' => ['$eq' => $kriteria],
//                 ]
//             ];

//             $response = $this->client->post($this->baseUrl . "/query", [
//                 'json' => $payload,
//             ]);

//             $data = json_decode($response->getBody()->getContents(), true);

//             if (!empty($data['matches'])) {
//                 $filteredResults = $this->filterContradictions($userAnswer, $data['matches']);

//                 return !empty($filteredResults) ? $filteredResults[0] : ['metadata' => 'not found', 'score' => 0];
//             }

//             return [
//                 'metadata' => 'not found',
//                 'score' => 0,
//             ];
//         } catch (\Exception $e) {
//             Log::error("Error querying Pinecone:", ['error' => $e->getMessage()]);
//             return [
//                 'error' => 'Failed to fetch search data.',
//             ];
//         }
//     }

//     /**
//      * Filter hasil yang memiliki kontradiksi dalam jawaban.
//      */
//     private function filterContradictions(string $userAnswer, array $results)
//     {
//         $userHasNegation = $this->containsNegation($userAnswer);

//         foreach ($results as &$result) {
//             $metadataAnswer = $result['metadata']['answer'] ?? '';
//             $answerHasNegation = $this->containsNegation($metadataAnswer);

//             // Jika hanya salah satu yang memiliki negasi, kurangi skornya secara drastis
//             if ($userHasNegation !== $answerHasNegation) {
//                 $result['score'] *= 0.5; // Skor dipotong 50%
//             }
//         }

//         // Urutkan kembali berdasarkan skor tertinggi setelah filtering
//         usort($results, fn($a, $b) => $b['score'] <=> $a['score']);

//         return $results;
//     }

//     /**
//      * Periksa apakah teks mengandung kata negasi/kontradiksi.
//      */
//     private function containsNegation(string $text)
//     {
//         foreach ($this->contradictionWords as $word) {
//             if (stripos($text, $word) !== false) {
//                 return true;
//             }
//         }
//         return false;
//     }
// }

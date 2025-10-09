<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\EmbeddingController;
use App\Http\Controllers\PineconeController;
use App\Http\Controllers\OpenAIController;
use App\Models\Hasil_Wawancara;

class ChatController extends Controller
{
    // Menampilkan halaman chat
   public function index(Request $request, $id_pendaftaran)
{
    if (!auth()->check() || auth()->user()->mahasiswa == null) {
        return redirect('/');
    }

    return view('chatbot.index', compact('id_pendaftaran'));
}

    public function chatsection($id_pendaftaran)
    {
        $nim = auth()->user()->mahasiswa->nim;
        //d($nim);
        // Hapus cache saat halaman diakses
        $this->clearCache($id_pendaftaran);

        // $inputSet = [];
        $inputSet = $this->getInputSet($id_pendaftaran);

        $startResponse = app(WawancaraController::class)->start($id_pendaftaran, false);

        if ($startResponse instanceof \Illuminate\Http\RedirectResponse) {
            return $startResponse;
        }

        // Inisialisasi cache baru dengan pertanyaan pertama dari kriteria pertama
        $firstQuestion = $inputSet[0]['pertanyaanList'][0]['pertanyaan'] ?? [];

        Cache::put('chatHistory'.$nim.$id_pendaftaran,[['sender' => 'bot', 'text' => $firstQuestion]], now()->addHours(1));
        Cache::put('currentQuestion'.$nim.$id_pendaftaran, $firstQuestion, now()->addHours(1));
        Cache::put('currentKriteria'.$nim.$id_pendaftaran, $inputSet[0]['kriteria'], now()->addHours(1));
        Cache::put('questionIndex'.$nim.$id_pendaftaran, 0, now()->addHours(1));
        Cache::put('kriteriaIndex'.$nim.$id_pendaftaran, 0, now()->addHours(1));
        Cache::put('followUpCount'.$nim.$id_pendaftaran, 0, now()->addHours(1));
        Cache::put('currentSoftskillsScore'.$nim.$id_pendaftaran, 0, now()->addHours(1));
        Cache::put('chatHistoryKriteria'.$nim.$id_pendaftaran, [], now()->addHours(1));
        Cache::put('questionScores'.$nim.$id_pendaftaran, [], now()->addHours(1));
        Cache::put('status'.$nim.$id_pendaftaran, 'unfinished', now()->addHours(1));

        return view('chatbot.wawancaraUtama', [
            'messages' => Cache::get('chatHistory'.$nim.$id_pendaftaran, []),
            'status' => Cache::get('status'.$nim.$id_pendaftaran, 'unfinished'),
            'id_pendaftaran' => $id_pendaftaran
        ]);
    }



    public function syaratdanketentuan($id_pendaftaran){
        if (auth()->user()->mahasiswa == null) {
            return redirect('/');
        } else {
            return view('chatbot.syaratdanketentuan', compact('id_pendaftaran'));
        }
    }
    public function historychat(Request $request){
        $nim = $request->input('nim');
        $id_pendaftaran = $request->input('id_pendaftaran');
        $kriteria = $request->input('kriteria');
        $hasilKesimpulan = Hasil_Wawancara::where('nim',$nim)->where('id_pendaftaran', $id_pendaftaran)
        ->first();

        return view('chatbot.historychat', [
        'hasilKesimpulan' => $hasilKesimpulan,
        'kriteria' => $kriteria
    ] );
    }

    //testting score
    public function testscore(Request $request)
    {
        $userAnswer = $request->input('answer');
        $question = $request->input('question');
        $kriteria = $request->input('kriteria');

        try {
            $embedAnswer = $this->embedUserAnswer($userAnswer);

            if (is_null($embedAnswer)) {
                return response()->json([
                    'status' => 'error',
                    'answer' => 'Embedding process failed, vector is null.'
                ], 400);
            }

            $pineconeResult = $this->searchData($embedAnswer, $question, $kriteria);
            Log::info("PR: " . json_encode($pineconeResult['score'] ?? 'No score'));

        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Internal server error'], 500);
        }

        return response()->json([
            'status' => 'success',
            'score_softskill' => $pineconeResult['metadata']['kategori'] ?? 'Unknown',
            // 'jawaban terdekat' => $pineconeResult['metadata']['answer'] ?? 'No data found',
        ]);
    }
    public $uniqueValue = "";
    // Menangani pengiriman pesan
    public function sendMessage(Request $request)
    {
        if (auth()->user()->mahasiswa == null) {
            $redirectUrl = redirect()->route('/')->getTargetUrl();
        }
        $nim = auth()->user()->mahasiswa->nim;
        $userAnswer = $request->input('message');
        $id_pendaftaran = $request->input('id_pendaftaran');
        $redirectUrl = null;

        $kriteriaIndex = Cache::get('kriteriaIndex'.$nim.$id_pendaftaran, 0);
        $questionIndex = Cache::get('questionIndex'.$nim.$id_pendaftaran, 0);
        $followUpCount = Cache::get('followUpCount'.$nim.$id_pendaftaran, 0);
        $chatHistory = Cache::get('chatHistory'.$nim.$id_pendaftaran, []);
        $chatHistoryKriteria = Cache::get('chatHistoryKriteria'.$nim.$id_pendaftaran, []);
        $questionScores = Cache::get('questionScores'.$nim.$id_pendaftaran, []);

        $inputSet = $this->getInputSet($id_pendaftaran);

        // Validasi index agar tidak out of bounds
        if (!isset($inputSet[$kriteriaIndex]['pertanyaanList'][$questionIndex])) {
            Log::error("Invalid questionIndex: " . json_encode($questionIndex));
            return response()->json(['error' => 'Invalid question index'], 400);
        }

        $currentQuestion = $inputSet[$kriteriaIndex]['pertanyaanList'][$questionIndex]['pertanyaan'];
        $jmlKategori = $inputSet[$kriteriaIndex]['pertanyaanList'][$questionIndex]['jmlKategori'];

        // 1. Simpan pertanyaan ke chatHistoryKriteria hanya jika ini pertanyaan baru
        if ($followUpCount == 0) {
            $chatHistoryKriteria[] = ['sender' => 'bot', 'text' => $currentQuestion];
        }

        // 2. Simpan jawaban user ke kedua history
        $chatHistory[] = ['sender' => 'user', 'text' => $userAnswer];
        $chatHistoryKriteria[] = ['sender' => 'user', 'text' => $userAnswer];

        if ($followUpCount == 0) {
            $embedAnswer = $this->embedUserAnswer($userAnswer);
            $pineconeResult = $this->searchData($embedAnswer, $currentQuestion, $inputSet[$kriteriaIndex]['kriteria']);
            Log::info("PR: " . json_encode($pineconeResult['score'] ?? 'No score'));

            if (isset($pineconeResult['score']) && $pineconeResult['score'] < 0.570) {
                $nextQuestion = "Jawaban Anda kurang sesuai dengan konteks pertanyaan, mohon jawab ulang.";
                $questionScores[] = [
                    'jmlKategori' => $jmlKategori,
                    'nilai' => 0
                ];
                Cache::put('questionScores'.$nim.$id_pendaftaran, $questionScores, now()->addHours(1));
                Log::info("skor pertanyaan: " . json_encode(0));
            } else {
                if (isset($pineconeResult['metadata'])) {
                    $softskillscore = $pineconeResult['metadata']['kategori'];
                    Cache::put('currentSoftskillsScore'.$nim.$id_pendaftaran, $softskillscore, now()->addHours(1));
                    $questionScores[] = [
                        'jmlKategori' => $jmlKategori,
                        'nilai' => $softskillscore
                    ];
                    Cache::put('questionScores'.$nim.$id_pendaftaran, $questionScores, now()->addHours(1));
                    Log::info("skor pertanyaan: " . json_encode($questionScores));
                }
                $nextQuestion = $this->getNextQuestion($userAnswer, $currentQuestion);
                Log::info("nextq: " . json_encode($nextQuestion));
            }

            Cache::put('followUpCount'.$nim.$id_pendaftaran, 1, now()->addHours(1));

        } elseif ($followUpCount == 1) {
            $nextQuestion = $this->getNextQuestion($userAnswer, $currentQuestion);
            Cache::put('followUpCount'.$nim.$id_pendaftaran, 2, now()->addHours(1));
        } else {
            if ($questionIndex + 1 >= count($inputSet[$kriteriaIndex]['pertanyaanList'])) {
                Log::info("chat history kriteria" . json_encode($chatHistoryKriteria));
                $conclusion = $this->conclude($chatHistoryKriteria);
                Log::info("Kesimpulan untuk kriteria " . $inputSet[$kriteriaIndex]['kriteria'] . ": " . json_encode($conclusion));

                Log::info("question scores: " . json_encode($questionScores));
                $kriteriaScore = $this->calculateKriteriaScore($questionScores);
                Log::info("Nilai kriteria " . $inputSet[$kriteriaIndex]['kriteria'] . ": " . $kriteriaScore);
                Log::info('kriteriascore'. $kriteriaScore);

                $saveWawancara = app(HasilWawancaraController::class)->simpanWawancara($id_pendaftaran,$inputSet[$kriteriaIndex]['kriteria'],$conclusion, $kriteriaScore, $chatHistoryKriteria);

                // Reset untuk kriteria baru
                $chatHistoryKriteria = [];
                $questionScores = [];
                Cache::put('chatHistoryKriteria'.$nim.$id_pendaftaran, $chatHistoryKriteria, now()->addHours(1));
                Cache::put('questionScores'.$nim.$id_pendaftaran, $questionScores, now()->addHours(1));
                Cache::put('followUpCount'.$nim.$id_pendaftaran, 0, now()->addHours(1));

                $kriteriaIndex++;
                Cache::put('kriteriaIndex'.$nim.$id_pendaftaran, $kriteriaIndex, now()->addHours(1));
                Cache::put('questionIndex'.$nim.$id_pendaftaran, 0, now()->addHours(1));

                if ($kriteriaIndex >= count($inputSet)) {
                    Cache::put('status'.$nim.$id_pendaftaran, 'finished', now()->addHours(1));
                    $nextQuestion = 'Wawancara selesai. Terima kasih atas partisipasi Anda!';
                    $redirectUrl = redirect()->route('lamaran_saya.detail', ['id' => $saveWawancara])->getTargetUrl();

                    Cache::forget('kriteriaIndex'.$nim.$id_pendaftaran);
                    Cache::forget('questionIndex'.$nim.$id_pendaftaran);
                    Cache::forget('followUpCount'.$nim.$id_pendaftaran);
                    Cache::forget('chatHistory'.$nim.$id_pendaftaran);
                    Cache::forget('chatHistoryKriteria'.$nim.$id_pendaftaran);
                    Cache::forget('questionScores'.$nim.$id_pendaftaran);
                    Cache::forget('currentSoftskillsScore'.$nim.$id_pendaftaran);
                } else {
                    $nextQuestion = $inputSet[$kriteriaIndex]['pertanyaanList'][0]['pertanyaan'];
                }
            } else {
                $nextQuestionIndex = $questionIndex + 1;
                Cache::put('questionIndex'.$nim.$id_pendaftaran, $nextQuestionIndex, now()->addHours(1));
                $nextQuestion = $inputSet[$kriteriaIndex]['pertanyaanList'][$nextQuestionIndex]['pertanyaan'];
                Cache::put('followUpCount'.$nim.$id_pendaftaran, 0, now()->addHours(1));
            }
        }

        // Simpan pertanyaan berikutnya ke kedua history
        $chatHistory[] = ['sender' => 'bot', 'text' => $nextQuestion];
        if ($followUpCount < 2) { // Hanya simpan jika bukan follow-up terakhir
            $chatHistoryKriteria[] = ['sender' => 'bot', 'text' => $nextQuestion];
        }

        Cache::put('currentQuestion'.$nim.$id_pendaftaran, $nextQuestion, now()->addHours(1));
        Cache::put('chatHistory'.$nim.$id_pendaftaran, $chatHistory, now()->addHours(1));
        Cache::put('chatHistoryKriteria'.$nim.$id_pendaftaran, $chatHistoryKriteria, now()->addHours(1));

        return response()->json([
            'status' => 'success',
            'score_softskill' => $softskillscore ?? 0,
            'interview_status' => Cache::get('status'.$nim.$id_pendaftaran, 'unfinished'),
            'next_question' => $nextQuestion,
            'redirect_url' => $redirectUrl
        ]);
    }

    // Helper method to get the current input set configuration
    private function getInputSet($id_pendaftaran)
    {
        $questions = app(WawancaraController::class)->getSpecificQuestion($id_pendaftaran);
        return $questions;
    }

    // Helper method to clear all cache
    private function clearCache($id_pendaftaran)
    {
        $nim = auth()->user()->mahasiswa->nim;
        Cache::forget('chatHistory'.$nim.$id_pendaftaran);
        Cache::forget('currentQuestion'.$nim.$id_pendaftaran);
        Cache::forget('currentKriteria'.$nim.$id_pendaftaran);
        Cache::forget('questionIndex'.$nim.$id_pendaftaran);
        Cache::forget('kriteriaIndex'.$nim.$id_pendaftaran);
        Cache::forget('followUpCount'.$nim.$id_pendaftaran);
        Cache::forget('chatHistoryKriteria'.$nim.$id_pendaftaran);
        Cache::forget('currentSoftskillScore');
    }

    // Embed jawaban pengguna
    private function embedUserAnswer($answer)
    {
        try {
            $embeddingController = app(EmbeddingController::class);
            $response = $embeddingController->embedAnswer(new Request(['answer' => $answer]));
            $data = json_decode($response->getContent(), true);
            return $data['embedding'] ?? null;
        } catch (\Exception $e) {
            Log::error('Error embedding answer: ' . $e->getMessage());
            return null;
        }
    }

    // Pencarian data dengan Pinecone
    private function searchData(array $vector, $question, $kriteria)
    {
        try {
            $pineconeController = app(PineconeController::class);
            $response = $pineconeController->search(new Request([
                'question' => $question,
                'kriteria' => $kriteria,
                'vector' => $vector
            ]));

            return json_decode($response->getContent(), true) ?? [];
        } catch (\Exception $e) {
            Log::error('Error searching data: ' . $e->getMessage());
            return [];
        }
    }

    // Mendapatkan pertanyaan selanjutnya
    private function getNextQuestion($userAnswer, $currentQuestion)
    {
        try {
            $openAIController = app(OpenAIController::class);
            $response = $openAIController->getNextQuestion(new Request([
                'answer' => $userAnswer,
                'question' => $currentQuestion,
            ]));

            $data = json_decode($response->getContent(), true);
            return $data['question'] ?? 'Tidak ada pertanyaan berikutnya.';
        } catch (\Exception $e) {
            Log::error('Error getting next question: ' . $e->getMessage());
            return 'Terjadi kesalahan dalam mendapatkan pertanyaan berikutnya.';
        }
    }

    // Kesimpulan
    public function conclude(array $chatHistory)
    {
        $openAIController = app(OpenAIController::class);
        try {
            $response = $openAIController->conclude(new Request([
                'chatHistory' => $chatHistory,
            ]));
            $data = json_decode($response->getContent(), true);
            return $data['conclusion'] ?? null;
        } catch (\Exception $e) {
            Log::error('Failed to conclude: ' . $e->getMessage());
            return null;
        }
    }

    // Nilai softskills
    private function scoreSoftskills($question, $answer, $kriteria)
    {
        $openAIController = app(OpenAIController::class);
        try {
            $response = $openAIController->scoreSoftskills(new Request([
                'question' => $question,
                'kriteria' => $kriteria,
                'jawaban' => $answer
            ]));
            $data = json_decode($response->getContent(), true);
            return $data['score'] ?? null;
        } catch (\Exception $e) {
            Log::error('Failed to score softskills: ' . $e->getMessage());
            return null;
        }
    }
    private function calculateKriteriaScore($questionScores)
    {
        if (empty($questionScores)) {
            return 0;
        }

        // Menentukan nilai maksimal kategori untuk penyetaraan
        $maxKategori = max(array_column($questionScores, 'jmlKategori'));

        $totalScore = 0;
        $totalQuestions = count($questionScores);

        foreach ($questionScores as $score) {
            // Menyetarakan nilai berdasarkan kategori tertinggi

            $normalizedScore = ($score['nilai'] / $score['jmlKategori']) * ($score['jmlKategori'] / $maxKategori);
            $totalScore += $normalizedScore;
        }

        // Menghitung nilai akhir dengan membaginya dengan jumlah pertanyaan
        $kriteriaScore = $totalScore / $totalQuestions;
        return $kriteriaScore;
    }



}

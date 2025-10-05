<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TrialchatController extends Controller
{
    private function getInputSet($id_pendaftaran)
    {
        $questions = [
            'pertanyaanList' => [
                [
                    'pertanyaan' => 'Apakah kamu sudah memahami dan membaca sesi wawancara dengan benar?',
                ]
            ]
        ];

        $trialQuestions = app(WawancaraController::class)->getTrialQuestion($id_pendaftaran);

        if ($trialQuestions  != null) {
            $formattedTrialQuestions = array_map(function($question) {
                return ['pertanyaan' => $question];
            }, $trialQuestions);

            $questions['pertanyaanList'] = array_merge($questions['pertanyaanList'], $formattedTrialQuestions);

            return [$questions];
        } else {
            return [$questions];
        }
    }

    public function trialChat($id_pendaftaran){
        // Hapus cache saat halaman diakses
        $this->clearCache($id_pendaftaran);
        $nim = auth()->user()->mahasiswa->nim;
        $inputSet = $this->getInputSet($id_pendaftaran);

        app(WawancaraController::class)->start($id_pendaftaran);

        // Inisialisasi cache baru dengan pertanyaan pertama
        $firstQuestion = $inputSet[0]['pertanyaanList'][0]['pertanyaan'];

        Cache::put('chatHistory'.$nim.$id_pendaftaran, [['sender' => 'bot', 'text' => $firstQuestion]], now()->addHours(1));
        Cache::put('currentQuestion'.$nim.$id_pendaftaran, $firstQuestion, now()->addHours(1));
        Cache::put('questionIndex'.$nim.$id_pendaftaran, 0, now()->addHours(1));
        Cache::put('followUpCount'.$nim.$id_pendaftaran, 0, now()->addHours(1));
        Cache::put('status'.$nim.$id_pendaftaran, 'unfinished', now()->addHours(1));
        Cache::put('inputSet', $inputSet, now()->addHours(1)); // Store the entire input set

        return view('chatbot.trialchat', [
            'messages' => Cache::get('chatHistory'.$nim.$id_pendaftaran, []),
            'status' => Cache::get('status'.$nim.$id_pendaftaran, 'unfinished'),
            'id_pendaftaran' => $id_pendaftaran
        ]);
    }

    public function syaratdanketentuan(){
        return view('chatbot.syaratdanketentuan');
    }

    // Menangani pengiriman pesan
    public function sendMessageTrial(Request $request)
    {
        // dd($request->all(), auth()->user());
        $nim = auth()->user()->mahasiswa->nim;
        try {
            // Validasi request
            $request->validate([
                'message' => 'required|string|max:255',
            ]);

            $id_pendaftaran = $request->input('id_pendaftaran');
            $userAnswer = $request->input('message');
            $inputSet = Cache::get('inputSet');
            $currentIndex = Cache::get('questionIndex'.$nim.$id_pendaftaran, 0);
            $chatHistory = Cache::get('chatHistory'.$nim.$id_pendaftaran, []);

            // Simpan pesan pengguna ke cache
            $chatHistory[] = ['sender' => 'user', 'text' => $userAnswer];

            // Cek apakah masih ada pertanyaan berikutnya
            $questions = $inputSet[0]['pertanyaanList'];
            $nextIndex = $currentIndex + 1;

            if (isset($questions[$nextIndex])) {
                // Ada pertanyaan berikutnya
                $nextQuestion = $questions[$nextIndex]['pertanyaan'];
                $chatHistory[] = ['sender' => 'bot', 'text' => $nextQuestion];

                // Update cache
                Cache::put('chatHistory'.$nim.$id_pendaftaran, $chatHistory, now()->addHours(1));
                Cache::put('currentQuestion'.$nim.$id_pendaftaran, $nextQuestion, now()->addHours(1));
                Cache::put('questionIndex'.$nim.$id_pendaftaran, $nextIndex, now()->addHours(1));
                Cache::put('status'.$nim.$id_pendaftaran, 'unfinished', now()->addHours(1));

                return response()->json([
                    'status' => 'success',
                    'interview_status' => 'unfinished',
                    'next_question' => $nextQuestion
                ]);
            } else {
                // Tidak ada pertanyaan lagi
                Cache::put('chatHistory'.$nim.$id_pendaftaran, $chatHistory, now()->addHours(1));
                Cache::put('status'.$nim.$id_pendaftaran, 'selesai', now()->addHours(1));

                $conclusion = app(ChatController::class)->conclude($chatHistory);

                // dd($conclusion);
                app(HasilWawancaraController::class)->simpanWawancara($id_pendaftaran, "Keterangan Lain", $conclusion, 0, $chatHistory);
                return response()->json([
                    'status' => 'success',
                    'interview_status' => 'selesai',
                    'next_question' => 'Baiklah, jika anda masih belum paham maka anda bisa kembali ke halaman sebelumnya untuk membaca panduan'
                ]);
            }
        } catch (\Exception $e) {
            // Log error dan kembalikan pesan error
            Log::error('Error in sendMessageTrial: ' . $e->getMessage());
            return Response::errorCatch($e, 'Terjadi kesalahan di server.');
        }
    }

    // Helper method to clear all cache
    private function clearCache($id_pendaftaran)
    {
        $nim = auth()->user()->mahasiswa->nim;
        Cache::forget('chatHistory'.$nim.$id_pendaftaran);
        Cache::forget('currentQuestion'.$nim.$id_pendaftaran);
        Cache::forget('questionIndex'.$nim.$id_pendaftaran);
        Cache::forget('followUpCount'.$nim.$id_pendaftaran);
        Cache::forget('status');
        Cache::forget('inputSet');
    }
}

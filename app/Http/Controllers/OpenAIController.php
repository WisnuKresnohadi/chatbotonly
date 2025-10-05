<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;

class OpenAIController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function getNextQuestion(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'answer' => 'required|string',
                'question' => 'required|string',
            ]);

            // Ambil pertanyaan berikutnya dari service
            $nextQuestion = $this->openAIService->getNextQuestion($validated['answer'], $validated['question']);

            // Kembalikan hanya pertanyaan dalam respons JSON
            return response()->json(['question' => $nextQuestion]);
        } catch (\Exception $e) {
            // Tangani error dan kembalikan pesan error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function conclude(Request $request)
    {
        $validated = $request->validate([
            'chatHistory' => 'required|array',
        ]);

        $conclusion = $this->openAIService->conclude($validated['chatHistory']);

        return response()->json(['conclusion' => $conclusion]);
    }


    public function scoreSoftskills(Request $request)
    {
        $validated = $request->validate([
            'kriteria' => 'required|string',
            'question' => 'required|string',
            'jawaban' => 'required|string',
        ]);

        $score = $this->openAIService->scoreSoftskills($validated['kriteria'], $validated['question'], $validated['jawaban']);

        return response()->json(['score' => $score]);
    }
}

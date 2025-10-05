<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PineconeService;

class PineconeController extends Controller
{
    private $pineconeService;

    public function __construct(PineconeService $pineconeService)
    {
        $this->pineconeService = $pineconeService;
    }

    /**
     * Handle POST request untuk mencari data dari Pinecone.
     */
    public function search(Request $request)
    {
        $request->validate([
            'vector' => 'required|array',
            'question' => 'required|string',
            'kriteria' => 'required|string',
        ]);

        $vector = $request->input('vector');
        $question = $request->input('question');
        $kriteria = $request->input('kriteria');

        $result = $this->pineconeService->searchData($vector, $question, $kriteria);

        return response()->json($result);
    }
}

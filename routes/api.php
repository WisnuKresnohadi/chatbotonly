<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\TrialchatController;
use App\Http\Controllers\EmbeddingController;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\PineconeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/openai/next-question', [OpenAIController::class, 'getNextQuestion']);
Route::post('/openai', [OpenAIController::class, 'post']);
Route::post('/getnextquestion', [OpenAIController::class, 'getNextQuestion'])->name('openai.next-question');
Route::post('/conclude', [OpenAIController::class, 'conclude'])->name('openai.conclude');
Route::post('/scoresoftskills', [OpenAIController::class, 'scoreSoftskills'])->name('openai.scoresoftskills');

Route::post('/embed-answer', [EmbeddingController::class, 'embedAnswer'])->name('openai.embeddings');
// Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
// Route::post('/chat/trial', [TrialchatController::class, 'sendMessageTrial'])->name('chat.sendTrial');
Route::post('/searchdata', [PineconeController::class, 'search'])->name('pinecone.search');

Route::post('/test-score', [ChatController::class, 'testscore'])->name('openai.testing');

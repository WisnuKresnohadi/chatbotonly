<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetPegawaiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $response = Http::post(env('PELNI_BASE_URL') . env('PELNI_GET_PEGAWAI'), [
            'token' => env('PELNI_TOKEN'),
            'last_modified' => '2024-01-01 00:00:00'
        ]);

        if($response->successful()){
            Log::info(json_encode($response->json()));
        }
    }
}

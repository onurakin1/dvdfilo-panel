<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReplicateService
{

    public static function predict(string $image, string $model, string $prompt, string $a_prompt = null, string $n_prompt = null)
    {


        $input  = [
            'version' => $model,
            'input' => [
                'image' => $image,
                'prompt' => $prompt,
                'a_prompt' => $a_prompt ?? "best quality",
                'n_prompt' => $n_prompt ?? "low quality",
                'num_samples' => "4"
            ],
            'webhook' => url('check-status'),
            'webhook_events_filter' => ["completed"]
        ];


        $response = Http::
        withOptions([
            'verify' => false,
        ])->
        withHeaders([
            'Authorization' => 'Token ' . env('REPLICATE_API_TOKEN'),
            'Content-Type' => 'application/json',
        ])->post('https://api.replicate.com/v1/predictions', $input);

        return $response->json();
    }

    public static function checkStatus(string $id, string $model)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'Authorization' => 'Token ' . env('REPLICATE_API_TOKEN'),
            'Content-Type' => 'application/json',
        ])->get('https://api.replicate.com/v1/predictions/' . $id);


        // Log::info('checkReplicate', ['result' => (array)$response->json()]);

        return $response->json();
    }
}

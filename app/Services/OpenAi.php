<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class OpenAi
{
    /**
     * Execute the OpenAI API call with a given prompt.
     *
     * @throws RequestException
     * @throws InvalidArgumentException
     */
    public static function execute(string $prompt, int $maxTokens = 4000): string
    {
        // $apiKey = 'openAiApiKey';

        // if ($apiKey === null) {
        //     throw new InvalidArgumentException('OpenAI API key is not provided in the configuration file.');
        // }

        $input_data = [
            'temperature' => 0.7,
            'max_tokens' => $maxTokens,
            'frequency_penalty' => 0,
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
        ];

        $response = Http::timeout(360)
            ->post('http://localhost:1234/v1/chat/completions', $input_data);
        // withHeaders([
        //     'Authorization' => 'Bearer '.$apiKey,
        //     'Content-Type' => 'application/json',
        // ])


        if ($response->failed()) {
            throw new RequestException($response);
        }

        $complete = $response->json();

        return $complete['choices'][0]['message']['content'];
    }
}

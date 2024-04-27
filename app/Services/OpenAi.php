<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class OpenAi
{
    /**
     * Execute the OpenAI API call with a given prompt.
     *
     * @throws RequestException
     * @throws InvalidArgumentException
     */
    public static function execute($context, string $message, int $maxTokens = 15000): string
    {
        // $apiKey = 'openAiApiKey';

        // if ($apiKey === null) {
        //     throw new InvalidArgumentException('OpenAI API key is not provided in the configuration file.');
        // }

        $data = [
            'temperature'       => 0.7,
            'max_tokens'        => $maxTokens,
            'frequency_penalty' => 0,
            // 'repeat_penalty' => 0,
            'model'    => 'gpt-3.5-turbo',
            'stream'   => true,
            'messages' => [
                [
                    'role'    => 'system',
                    'content' => $context,
                ],
                [
                    'role'    => 'user',
                    'content' => $message,
                ],
            ],

        ];

        $response = Http::withHeaders([
            // 'Authorization' => 'Bearer '.$apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(480)
            // ->post('http://localhost:1234/v1/chat/completions', $data);
            ->post('https://books-peru-attach-if.trycloudflare.com/v1/chat/completions', $data);

        if ($response->failed()) {
            throw new RequestException($response);
        }

        $completion = $response->json();

        $content = trim($response['choices'][0]['message']['content'] ?? '');

        $complet = $completion['choices'][0]['message']['content'];

        Log::info('open ai log :', [$completion, $content, $response]);

        return $content;
    }
}

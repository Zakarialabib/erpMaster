<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class KoboldAIService
{
    private const USER = 'User:';
    private const BOT = 'Bot:';
    private const ENDPOINT = 'http://localhost:5001/api';

    public function getPrompt($userMessage, $context)
    {
        $prompt = json_encode([
            [
                'role'    => 'system',
                'content' => $context,
            ],
            [
                'role'    => 'user',
                'content' => $userMessage,
            ],
        ]);

        return [
            'prompt'             => $prompt,
            'use_story'          => 'False',
            'use_memory'         => 'False',
            'use_authors_note'   => 'False', # Use the authors notes from the KoboldAI UI, can be managed using other API calls (See /api for the documentation)
            'use_world_info'     => 'False', # Use the World Info from the KoboldAI UI, can be managed using other API calls (See /api for the documentation)
            'max_context_length' => 7000, # How much of the prompt will we submit to the AI generator? (Prevents AI / memory overloading)
            'max_length'         => 1024, # How long should the response be?
            'rep_pen'            => 1.1, # Prevent the AI from repeating itself
            'rep_pen_range'      => 2048, # The range to which to apply the previous
            'rep_pen_slope'      => 0.7, # This number determains the strength of the repetition penalty over time
            'temperature'        => 0.8, # How random should the AI be? In a low value we pick the most probable token, high values are a dice roll
            'tfs'                => 0.97, # Tail free sampling, https://www.trentonbricken.com/Tail-Free-Sampling/
            'top_a'              => 0.0, # Top A sampling , https://github.com/BlinkDL/RWKV-LM/tree/4cb363e5aa31978d801a47bc89d28e927ab6912e#the-top-a-sampling-method
            'top_k'              => 0, # Keep the X most probable tokens
            'top_p'              => 0.9, # Top P sampling / Nucleus Sampling, https://arxiv.org/pdf/1904.09751.pdf
            'typical'            => 1.0, # Typical Sampling, https://arxiv.org/pdf/2202.00666.pdf
            'sampler_order'      => [6, 0, 1, 3, 4, 2, 5], # Order to apply the samplers, our default in this script is already the optimal one. KoboldAI Lite contains an easy list of what the
            // "stop_sequence" => "{$user}", # When should the AI stop generating? In this example we stop when it tries to speak on behalf of the user.
            #"sampler_seed": 1337, # Use specific seed for text generation? This helps with consistency across tests.
            'singleline'               => 'False', # Only return a response that fits on a single line, this can help with chatbots but also makes them less verbose
            'sampler_full_determinism' => 'False', # Always return the same result for the same query, best used with a static seed
            'frmttriminc'              => 'True', # Trim incomplete sentences, prevents sentences that are unfinished but can interfere with coding and other non english sentences
            'frmtrmblln'               => 'False', #Remove blank lines
            'quiet'                    => 'False', # Don't print what you are doing in the KoboldAI console, helps with user privacy            "quiet" => "False"
        ];
    }

    public function processUserMessage($userMessage, $context)
    {
        try {
            $prompt = $this->getPrompt($userMessage, $context);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(480)
                ->post(self::ENDPOINT.'/v1/generate', $prompt);

            if ($response->failed()) {
                throw new RequestException($response);
            }

            if ($response->status() == 200) {
                $results = $response->json()['results'];

                Log::info('results', [$results]);

                $text = $results[0]['text'];
                $responseText = trim(explode("\n", $text)[0]);

                Log::info('responseText', [$responseText]);

                return $responseText;
            } else {
                return 'Error: '.$response->status();
            }
        } catch (Exception $e) {
            return 'An error occurred: '.$e->getMessage();
        }
    }
}

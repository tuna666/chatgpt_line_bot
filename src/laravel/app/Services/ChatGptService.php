<?php

namespace App\Services;

use GuzzleHttp\Client;

class ChatGptService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/engines/davinci-codex/completions',
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function getResponse($prompt)
    {
        $response = $this->client->post('', [
            'json' => [
                'prompt' => $prompt,
                'max_tokens' => 50,
                'n' => 1,
                'stop' => null,
                'temperature' => 0.5,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}

<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;

class OpenAIHelper
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . config('openai.openai_key'),
                'Content-Type'  => 'application/json',
            ],
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function generateProductDescription($category)
    {
        $prompt = "Bir e-ticaret platformunda satılacak olan {$category} kategorisindeki bir ürün için açıklama oluştur. Açıklama, ürünün özelliklerini, kullanım amacını ve alıcılar için cazip olmasını vurgulamalıdır. Ürün açıklaması çok uzun olmamalı, kısa ve öz olmalı.";

        $response = $this->client->post('chat/completions', [
            'json' => [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ],
        ]);

        return Arr::get(json_decode($response->getBody(), true),'choices.0.message.content') ?? 'Boş';
    }
}

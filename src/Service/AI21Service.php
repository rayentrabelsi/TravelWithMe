<?php

namespace App\Service;

use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AI21Service
{
    private $httpClient;
    private $apiKey;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->httpClient = new Client(['base_uri' => 'https://api.ai21.com']);
        $this->apiKey = $parameterBag->get('AI21_API_KEY');
    }

    public function generateResponse(string $input): array
    {
        $response = $this->httpClient->post('/studio/v1/j2-mid/complete', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'prompt' => $input,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}

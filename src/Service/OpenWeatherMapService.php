<?php
// src/Service/OpenWeatherMapService.php

namespace App\Service;

use GuzzleHttp\Client;

class OpenWeatherMapService
{
    private $apiKey = '65025a085f2eb3790711bcc62025f0b4'; // Assign API key here
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://api.openweathermap.org/data/2.5/',
        ]);
    }

    public function getCurrentWeather(string $city): array
    {
        $response = $this->client->request('GET', 'weather', [
            'query' => [
                'q' => $city,
                'appid' => $this->apiKey,
                'units' => 'metric', // Use metric units (Celsius)
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
    public function getCurrentWeatherByCoordinates(float $latitude, float $longitude): array
    {
        $response = $this->client->request('GET', 'weather', [
            'query' => [
                'lat' => $latitude,
                'lon' => $longitude,
                'appid' => $this->apiKey,
                'units' => 'metric', // Use metric units (Celsius)
            ],
        ]);
    
        return json_decode($response->getBody()->getContents(), true);
    }
}
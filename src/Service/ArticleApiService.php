<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ArticleApiService
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetchArticles(): array
    {
        $response = $this->httpClient->request('GET', 'http://localhost:3999/api/school/articles');

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error fetching articles from API');
        }

        return $response->toArray(); // Convertir la réponse JSON en tableau PHP
    }
}

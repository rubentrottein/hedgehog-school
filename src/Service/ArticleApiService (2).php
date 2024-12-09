<?php

namespace App\Service;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
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

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function fetchArticleById(string $id): array
    {
        $response = $this->httpClient->request('GET', 'http://localhost:3999/api/school/article/'.$id);
        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error fetching article from API');
        }
        return $response->toArray(); // Convertir la réponse JSON en tableau PHP
    }
}

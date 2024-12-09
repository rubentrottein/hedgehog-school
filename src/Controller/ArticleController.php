<?php

namespace App\Controller;

use App\Service\ArticleApiService;
use App\Repository\UserRepository;
use App\Form\ArticleFormType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ArticleController extends AbstractController
{


    public function __construct(UserRepository $userRepository, ArticleApiService $articleApiService, HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->articleApiService = $articleApiService;
        $this->userRepository = $userRepository;
    }

    public ArticleApiService $articleApiService;
    public UserRepository $userRepository;
    private HttpClientInterface $httpClient;

    #[Route('/articles', name: 'default_articles', methods: ['GET', 'POST'])]
    public function articles(Request $request): Response
    {
        try {
            $articles = file_get_contents('http://localhost:3999/api/school/articles');
            $articlesList = json_decode($articles, true);
            $lastArticle = end($articlesList);
            return $this->render("default/articles.html.twig", ['articles' => $articlesList, 'lastArticle' => $lastArticle]);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $articlesList = [$exception->getMessage()];
            return $this->render('default/articles.html.twig', ["articles" => $articlesList,"error" => $error, 'lastArticle' => $lastArticle]);
        }
    }

    #[Route('/test', name: 'default_test', methods: ['GET', 'POST'])]
    public function test(): Response
    {

        #2
        //$users = $this-> $userRepository->findAll();
        $posts = $this->articleApiService->fetchArticles();

        return $this->render('default/test.html.twig',
            ['posts' => $posts]);

    }

    /**
     * @throws \Exception
     *
{#
    #[Route('/article/{id}', name: 'article_get_one', methods: ['GET'])]
    public function getArticleById(string $id): Response
    {

        $article = $this->articleApiService->fetchArticleById($id);
        try {
            return $this->render('default/test.html.twig',
                ['post' => $article]);
        } catch (Exception $e) {
            dd($e);
        }
    }
#}
     * /**/
    #[Route('/article/{id}', name: 'article_get_one', methods: ['GET'])]
    public function displayArticle(string $id) : Response
    {
        #2
        //$users = $this-> $userRepository->findAll();
        $posts = $this->articleApiService->fetchArticles();
        try {

            $post = $this->articleApiService->fetchArticleById($id);
        } catch (Exception|DecodingExceptionInterface|TransportExceptionInterface $e) {
            dd($e->getMessage());
        }
        $message = ['content' => 'Message Flash', 'type' => "success"];
        return $this->render('default/home.html.twig',
            ['posts' => $posts, 'message' => $message, 'article' => $post]
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/create-article/', name: 'article_create', methods: ['GET', 'POST'])]
    public function createArticle(Request $request): Response
    {
        $form = $this->createForm(ArticleFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleData = $form->getData();
            // Ajouter les dates actuelles
            $currentDateTime = new \DateTimeImmutable();
            $articleData['createdAt'] = $currentDateTime->format('Y-m-d H:i:s');
            $articleData['updatedAt'] = $currentDateTime->format('Y-m-d H:i:s');

            // Ajouter l'auteur (utilisateur connecté)
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();

            // Vérifier que l'utilisateur n'est pas null
            if ($user !== null) {
                $articleData['author'] = $user->getUsername();
            } else {
                // Gérer le cas où l'utilisateur n'est pas connecté
                $this->addFlash('error', 'Vous devez être connecté pour créer un article.');
                return $this->redirectToRoute('app_login');
            }

            $response = $this->httpClient->request('POST', 'http://localhost:3999/api/school/articles/add', [
                'json' => $articleData,
            ]);

            if ($response->getStatusCode() === 201) {
                $this->addFlash('success', 'Article créé avec succès');
                return $this->redirectToRoute('article_get_one', ['id' => $articleData->getId()]);
            } else {
                $this->addFlash('error', 'Erreur lors de la création de l\'article');
            }
        }

        return $this->render('article/createArticle.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
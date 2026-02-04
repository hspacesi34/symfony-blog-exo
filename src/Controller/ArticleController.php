<?php

namespace App\Controller;

use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
    public function __construct(
        private ArticleService $articleService
    )
    {}

    #[Route('/articles', name: 'app_articles')]
    public function articles(): Response
    {
        $articles = $this->articleService->getAll();
        return $this->render('article/articles.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{id}', name: 'app_article')]
    public function article(int $id): Response
    {
        $article = $this->articleService->getOne($id);
        return $this->render('article/article.html.twig', [
            'article' => $article,
        ]);
    }
}

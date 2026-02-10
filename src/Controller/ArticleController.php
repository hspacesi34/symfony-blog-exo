<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleType;
use App\Service\ArticleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/article')]
final class ArticleController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private ArticleService $articleService
    ) {}

    #[Route('/all', name: 'app_article_all')]
    public function articles(): Response
    {
        $articles = $this->articleService->getAll();
        return $this->render('article/articles.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/one/{id}', name: 'app_article_one')]
    public function article(int $id): Response
    {
        $article = $this->articleService->getOne($id);
        return $this->render('article/article.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/add', name: 'app_article_add')]
    public function addArticle(Request $request): Response
    {
        $result = $this->articleService->addArticle($request);

        if ($result['success']) {
            $this->addFlash('success', 'Article ajouté avec succès');
        }
        
        return $this->render('article/add.html.twig', [
            'articleForm' => $result['form']->createView()
        ]);
    }
}

<?php

namespace App\Controller;

use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryService $categoryService
    )
    {}

    #[Route('/categories', name: 'app_categories')]
    public function categories(): Response
    {
        $categories = $this->categoryService->getAll();
        return $this->render('category/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/{id}', name: 'app_category')]
    public function category(int $id): Response
    {
        $category = $this->categoryService->getOne($id);
        return $this->render('category/category.html.twig', [
            'category' => $category,
        ]);
    }
}

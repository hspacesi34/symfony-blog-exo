<?php

namespace App\Controller;

use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/category')]
final class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryService $categoryService
    ) {}

    #[Route('/all', name: 'app_category_all')]
    public function categories(): Response
    {
        $categories = $this->categoryService->getAll();
        return $this->render('category/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/one/{id}', name: 'app_category_one')]
    public function category(int $id): Response
    {
        $category = $this->categoryService->getOne($id);
        return $this->render('category/category.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/add', name: 'app_category_add')]
    public function addCategory(Request $request): Response
    {
        $result = $this->categoryService->addCategory($request);

        if ($result['submitted'] && $result['valid']) {
            $this->addFlash('success', 'Catégorie ajoutée avec succès');
            return $this->redirectToRoute('app_category_add');
        }

        return $this->render('category/add.html.twig', [
            'categoryForm' => $result['form']
        ]);
    }
}

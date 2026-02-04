<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Entity;
use App\Repository\CategoryRepository;

class CategoryService extends AbstractService
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {}

    public function getOne(int $id): ?Category
    {
        return $this->categoryRepository->find($id);
    }

    public function getAll(): array
    {
        return $this->categoryRepository->findAll();
    }
}

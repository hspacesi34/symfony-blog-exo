<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Entity;
use App\Repository\ArticleRepository;

class ArticleService extends AbstractService
{
    public function __construct(
        private ArticleRepository $articleRepository
    ) {}

    public function getOne(int $id): ?Article
    {
        return $this->articleRepository->find($id);
    }

    public function getAll(): array
    {
        return $this->articleRepository->findAll();
    }
}

<?php

namespace App\Service;

use App\Entity\{Article};
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ArticleType;

class ArticleService extends AbstractService
{

    public function getOne(int $id): ?Article
    {
        return $this->articleRepository->find($id);
    }

    public function getAll(): array
    {
        return $this->articleRepository->findAll();
    }

    public function addArticle(Request $request): array
    {
        $form = $this->ffi->create(ArticleType::class, new Article());
        $form->add('submit', SubmitType::class, [
                'label' => 'Publier l’article',
                'attr' => [
                    'class' => 'btn btn-primary mt-6',
                ],
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $user = $this->security->getUser();
            $article->setWriteBy($user)
                    ->setCreatedAt(new \DateTimeImmutable());
            $this->em->persist($article);
            $this->em->flush();

            return [
                'success' => true,
                'form' => $form
            ];
        }
        return [
            'success' => false,
            'form' => $form
        ];
    }
}

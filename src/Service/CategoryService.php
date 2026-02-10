<?php

namespace App\Service;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class CategoryService extends AbstractService
{

    public function getOne(int $id): ?Category
    {
        return $this->categoryRepository->find($id);
    }

    public function getAll(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function addCategory(Request $request): array
    {
        $form = $this->ffi->create(CategoryType::class, new Category());
        $form->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $category = $form->getData();
                $this->em->persist($category);
                $this->em->flush();

                return [
                    'submitted' => true,
                    'valid' => true,
                    'form' => $form
                ];
            } else {
                return [
                    'submitted' => true,
                    'valid' => false,
                    'form' => $form
                ];
            }
        }
        return [
            'submitted' => false,
            'valid' => false,
            'form' => $form
        ];
    }
}

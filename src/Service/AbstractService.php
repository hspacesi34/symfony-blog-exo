<?php

namespace App\Service;

use App\Entity\Entity;
use App\Repository\ArticleRepository;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\SecurityBundle\Security;

abstract class AbstractService
{
    protected FormFactoryInterface $ffi;
    protected EntityManagerInterface $em;
    protected CategoryRepository $categoryRepository;
    protected UserRepository $userRepository;
    protected ArticleRepository $articleRepository;
    protected UserPasswordHasherInterface $userPasswordHasher;
    protected Security $security;

    public function __construct(
        FormFactoryInterface $ffi, 
        EntityManagerInterface $em, 
        CategoryRepository $categoryRepository,
        UserRepository $userRepository,
        ArticleRepository $articleRepository,
        UserPasswordHasherInterface $userPasswordHasher,
        Security $security
        )
    {
        $this->ffi = $ffi;
        $this->em = $em;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->security = $security;
    }

    public abstract function getOne(int $id): ?Entity;

    public abstract function getAll(): array;

    public function clearForm(string $formType, Entity $object): Form
    {
        $form = $this->ffi->create($formType, $object);
        $form->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
            ]);
        return $form;
    }
}

<?php

namespace App\Service;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService extends AbstractService
{

    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $em,
        private FormFactoryInterface $ffi,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {}

    public function getOne(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function getAll(): array
    {
        return $this->userRepository->findAll();
    }

    public function getOneByEmail(string $email): ?User
    {
        return $this->userRepository->findOneBy(['email_user' => $email]);
    }

    public function addUser(Request $request): array
    {
        $user = new User();
        $form = $this->ffi->create(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $plainPassword = $form->get('plainPassword')->getData();
                $user->setPassword($this->userPasswordHasher->hashPassword($user, $plainPassword));
                $user->setCreatedAt(new \DateTimeImmutable());
                $user->setRoles(["ROLE_USER"]);
                $this->em->persist($user);
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

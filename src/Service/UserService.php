<?php

namespace App\Service;

use App\Entity\Entity;
use App\Entity\User;
use App\Repository\UserRepository;

class UserService extends AbstractService
{

    public function __construct(
        private UserRepository $userRepository
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
}

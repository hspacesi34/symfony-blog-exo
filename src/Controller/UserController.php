<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    public function __construct(
        private UserService $userService
    )
    {}

    #[Route('/members', name: 'app_user_members')]
    public function members(): Response
    {
        $users = $this->userService->getAll();
        return $this->render('user/members.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/account/{email}', name: 'app_user_account')]
    public function account(string $email): Response
    {
        $user = $this->userService->getOneByEmail($email);
        return $this->render('user/account.html.twig', [
            'user' => $user
        ]);
    }
}

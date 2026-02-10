<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/user')]
final class UserController extends AbstractController
{
    public function __construct(
        private UserService $userService
    )
    {}

    #[Route('/all', name: 'app_user_all')]
    public function members(): Response
    {
        $users = $this->userService->getAll();
        return $this->render('user/members.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/one/{email}', name: 'app_user_one')]
    public function account(string $email): Response
    {
        $user = $this->userService->getOneByEmail($email);
        return $this->render('user/account.html.twig', [
            'user' => $user
        ]);
    }
}

<?php

namespace App\Controller;


use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        private UserService $userService
    ) {}

    #[Route('/register', name: 'app_register')]
    public function register(Request $request): Response
    {
        $result = $this->userService->addUser($request);

        if ($result['submitted'] && $result['valid']) {
            $this->addFlash('success', 'Enregistrement bien effectué');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $result['form']
        ]);
    }
}

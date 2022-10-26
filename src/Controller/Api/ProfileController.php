<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/api/profile', name: 'app_api_user_profile')]
    public function __invoke(): Response
    {
        $user = $this->getUser();
        return new JsonResponse([
            'email' => $user->getUserIdentifier()
        ]);
    }
}

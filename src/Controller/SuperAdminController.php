<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuperAdminController extends AbstractController
{
    #[Route('/super-admin', name: 'app_super_admin')]
    public function __invoke(): Response
    {
        return $this->render('profile/index.html.twig');
    }
}

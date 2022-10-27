<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Security\UserVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UsersListController extends AbstractController
{
    #[Route('/users', name: 'app_users_list')]
    public function __invoke(UserRepository $userRepository, Security $security): Response
    {
        $users = $userRepository->findAll();
        foreach ($users as $user) {
            $security->isGranted(UserVoter::VIEW, $user);
            $this->denyAccessUnlessGranted(UserVoter::VIEW, $user);
        }
        return $this->render('users_list/index.html.twig', ['users' => $users]);
    }
}

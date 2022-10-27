<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Security\ArticleVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesListController extends AbstractController
{
    #[Route('/articles', name: 'app_articles_list')]
    public function __invoke(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        foreach ($articles as $article) {
            $this->denyAccessUnlessGranted(ArticleVoter::VIEW, $article);
        }
        return $this->render('articles_list/index.html.twig', ['articles' => $articles]);
    }
}

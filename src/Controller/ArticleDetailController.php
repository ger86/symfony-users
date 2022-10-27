<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleDetailController extends AbstractController
{
    #[Route('/articles/{id}', name: 'app_article_detail')]
    public function __invoke(string|int $id, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->find($id);
        if ($article === null) {
            throw $this->createNotFoundException();
        }
        return $this->render('article_detail/index.html.twig', ['article' => $article]);
    }
}

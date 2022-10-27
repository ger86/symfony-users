<?php

namespace App\Command;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\String\ByteString;

#[AsCommand(name: 'app:articles:generate')]
class GenerateArticlesCommand extends Command
{

    public function __construct(private ArticleRepository $articleRepository, private UserRepository $userRepository, private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->userRepository->findAll();
        $countUsers = \count($users);

        for ($i = 0; $i < 50; $i++) {
            $article = new Article(ByteString::fromRandom(30), $users[$i % $countUsers]);
            $this->articleRepository->add($article, false);
        }
        $this->em->flush();
        return Command::SUCCESS;
    }
}

<?php

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:user:set-roles')]
class SetUserRolesCommand extends Command
{

    public function __construct(private UserRepository $userRepository)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userRepository->findOneByEmail('gerardo@latteandcode.com');
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $this->userRepository->add($user);
        return Command::SUCCESS;
    }
}

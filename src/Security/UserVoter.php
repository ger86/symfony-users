<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class UserVoter extends Voter
{
    const VIEW = 'user.view';

    public function __construct(private Security $security)
    {
    }


    protected function supports(string $attribute, mixed $subject): bool
    {
        dump('UserVoter supports');
        if (!in_array($attribute, [self::VIEW])) {
            return false;
        }

        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $currentUser = $token->getUser();

        if (!$currentUser instanceof User) {
            return false;
        }

        /** @var User $user */
        $user = $subject;

        return match ($attribute) {
            self::VIEW => $this->canView($user, $currentUser),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canView(User $user, User $currentUser): bool
    {
        return $user === $currentUser || $this->security->isGranted('ROLE_SUPER_ADMIN');
    }
}

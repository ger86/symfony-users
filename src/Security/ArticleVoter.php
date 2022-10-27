<?php

namespace App\Security;

use App\Entity\Article;
use App\Entity\User;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\CacheableVoterInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ArticleVoter extends Voter implements CacheableVoterInterface
{
    const VIEW = 'article.view';
    const EDIT = 'article.edit';

    public function __construct(private Security $security)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        dump('ArticleVoter supports');
        if (!$subject instanceof Article) {
            return false;
        }

        if (!in_array($attribute, [self::VIEW])) {
            return false;
        }

        return true;
    }

    // public function supportsAttribute(string $attribute): bool
    // {
    //     return str_starts_with($attribute, 'article.');
    // }

    // public function supportsType(string $subjectType): bool
    // {
    //     dump($subjectType); // User::class
    //     return Article::class === $subjectType;
    // }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $currentUser = $token->getUser();

        if (!$currentUser instanceof User) {
            return false;
        }

        /** @var Article $article */
        $article = $subject;

        return match ($attribute) {
            self::VIEW => $this->canView($article, $currentUser),
            self::EDIT => $this->canEdit($article, $currentUser),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canView(Article $article, User $currentUser): bool
    {
        return $article->getUser() === $currentUser;
    }

    private function canEdit(Article $article, User $currentUser): bool
    {
        return $article->getUser() === $currentUser;
    }
}

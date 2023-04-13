<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    public const CREATE = 'create';
    public const UPDATE = 'update';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::CREATE, self::UPDATE])) {
            return false;
        }

        // only vote on `User` objects
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        return match ($attribute) {
            self::CREATE => $this->canCreate($user),
            self::UPDATE => $this->canUpdate($user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canCreate(User $user): bool
    {
        return $user->getRoles()[0] === "ROLE_ADMIN";
    }

    private function canUpdate(User $user): bool
    {
        return $user->getRoles()[0] === "ROLE_ADMIN";
    }
}

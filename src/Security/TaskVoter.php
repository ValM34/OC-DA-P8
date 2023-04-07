<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\Task;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TaskVoter extends Voter
{
  const HANDLE = 'handle';

  protected function supports(string $attribute, mixed $subject): bool
  {
    // if the attribute isn't one we support, return false
    if (!in_array($attribute, [self::HANDLE])) {
      return false;
    }

    // only vote on `User` objects
    if (!$subject instanceof Task) {
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
      self::HANDLE => $this->canHandle($subject, $user),
      default => throw new \LogicException('This code should not be reached!')
    };
  }

  private function canHandle(mixed $subject, User $user)
  {
    return $subject->getUser() === $user;
  }
}

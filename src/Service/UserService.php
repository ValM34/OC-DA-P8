<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\AppCustomAuthenticator;
use Symfony\Component\HttpFoundation\Request;

class UserService implements UserServiceInterface
{
  public function __construct(
    private UserPasswordHasherInterface $userPasswordHasher,
    private EntityManagerInterface $entityManager,
    private UserAuthenticatorInterface $userAuthenticator,
    private AppCustomAuthenticator $authenticator
  ) {
  }

  public function display(): array
  {
    return $this->entityManager->getRepository(User::class)->findAll();
  }

  public function create(User $user, string $plainPassword, Request $request): void
  {
    $this->define($user, $plainPassword);

    $this->userAuthenticator->authenticateUser($user, $this->authenticator, $request);
  }

  public function update(User $user, string $plainPassword): void
  {
    $this->define($user, $plainPassword);
  }

  public function define(User $user, string $plainPassword): void
  {
    $user->setPassword($this->userPasswordHasher->hashPassword($user, $plainPassword));

    $this->entityManager->persist($user);
    $this->entityManager->flush();
  }
}

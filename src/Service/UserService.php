<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\AppCustomAuthenticator;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use DateTimeImmutable;

class UserService implements UserServiceInterface
{
    private $dateTimeImmutable;

    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private EntityManagerInterface $entityManager,
        private UserAuthenticatorInterface $userAuthenticator,
        private AppCustomAuthenticator $authenticator
    ) {
        $this->dateTimeImmutable = new DateTimeImmutable();
    }

    public function display(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    public function create(User $user, string $plainPassword, Request $request): void
    {
        $date = $this->dateTimeImmutable;
        $user
          ->setCreatedAt($date)
          ->setUpdatedAt($date)
          ->setRoles(["ROLE_USER"])
        ;
        $this->define($user, $plainPassword);
        $this->userAuthenticator->authenticateUser($user, $this->authenticator, $request);
    }

    public function update(User $user, string $plainPassword): void
    {
        $user->setUpdatedAt($this->dateTimeImmutable);
        $this->define($user, $plainPassword);
    }

    public function define(User $user, string $plainPassword): void
    {
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $plainPassword));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}

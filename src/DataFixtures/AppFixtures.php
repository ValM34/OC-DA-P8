<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Task;
use DateTimeImmutable;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $date = new DateTimeImmutable();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, 'password');
            $user
                ->setEmail('user' . $i . '@user.fr')
                ->setRoles(["ROLE_USER"])
                ->setPassword($password)
                ->setUsername("username-user " . $i)
                ->setCreatedAt($date)
                ->setUpdatedAt($date);
            $manager->persist($user);

            $this->addTaskForUser($user, $manager);

            $user = new User();
            $password = $this->hasher->hashPassword($user, 'password');
            $user
                ->setEmail('user' . $i . '@admin.fr')
                ->setRoles(["ROLE_ADMIN"])
                ->setPassword($password)
                ->setUsername("username-admin " . $i)
                ->setCreatedAt($date)
                ->setUpdatedAt($date);
            $manager->persist($user);
        }

        $this->addTaskForUser($user, $manager);

        $manager->flush();
    }

    public function addTaskForUser(User $user, ObjectManager $manager)
    {
        $date = new DateTimeImmutable();

        for ($i = 0; $i < 10; $i++) {
            $task = new Task();
            $task
                ->setTitle('Tâche' . $i)
                ->setContent('Contenu de la tâche')
                ->setUser($user)
                ->setIsDone(false)
                ->setCreatedAt($date)
                ->setUpdatedAt($date);
            $manager->persist($task);
        }
    }
}

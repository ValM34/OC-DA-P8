<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private TaskRepository $taskRepository;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->taskRepository = $this->entityManager->getRepository(Task::class);
        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    public function testFindByIsDone(): void
    {
        $user = $this->userRepository->findOneBy(['email' => 'user0@user.fr']);
        $tasks = $this->taskRepository->findByIsDone($user, false);
        $this->assertInstanceOf(Task::class, $tasks[0]);
        $this->assertFalse($tasks[0]->isIsDone());
    }
}

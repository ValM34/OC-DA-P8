<?php

namespace App\Tests\Task;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class ToggleTaskActionTest extends WebTestCase
{
  private KernelBrowser $client;
  private EntityManagerInterface $entityManager;
  
  protected function setUp(): void
  {
      $this->client = static::createClient();
      $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
  }

  public function testToggleTaskAction(): void
  {
    $entityManager = $this->client->getContainer()->get(EntityManagerInterface::class);
    $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'user1@user.fr']);
    $this->client->loginUser($user);
    $task = $this->findTask();
    // if Task isDone
    $task->setIsDone(true);
    $this->client->request(Request::METHOD_GET, '/tasks/' . $task->getId() . '/toggle');
    self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
    // if Task is not done
    $task->setIsDone(false);
    $this->client->request(Request::METHOD_GET, '/tasks/' . $task->getId() . '/toggle');
    self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
  }

  public function findTask(): Task
  {
    $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'user1@user.fr']);
    $tasksList = $this->entityManager->getRepository(Task::class)->findBy(['user' => $user]);

    return $tasksList[0];
  }
}

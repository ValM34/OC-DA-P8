<?php

namespace App\Tests\Task;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Task;

class DeleteTaskActionTest extends WebTestCase
{
  private $client;
  private $entityManager;
  
  protected function setUp(): void
  {
      $this->client = static::createClient();
      $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
  }

  public function testDeleteTaskAction()
  {
    $taskId = $this->findTask();
    $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'user1@user.fr']);
    $this->client->loginUser($user);
    $this->client->request(Request::METHOD_GET, '/tasks/' . $taskId . '/delete');
    self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
  }

  public function findTask()
  {
    $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'user1@user.fr']);
    $tasksList = $this->entityManager->getRepository(Task::class)->findBy(['user' => $user]);

    return $tasksList[0]->getId();
  }
}

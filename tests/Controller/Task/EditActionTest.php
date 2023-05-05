<?php

namespace App\Tests\Controller\Task;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class EditActionTest extends WebTestCase
{
  private KernelBrowser $client;
  private EntityManagerInterface $entityManager;
  
  protected function setUp(): void
  {
      $this->client = static::createClient();
      $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
  }

  public function testEditAction(): void
  {
    $entityManager = $this->client->getContainer()->get(EntityManagerInterface::class);
    $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'user1@user.fr']);
    $this->client->loginUser($user);
    $task = $this->findTask();
    $this->client->request(Request::METHOD_GET, '/tasks/' . $task . '/edit');
    self::assertResponseIsSuccessful();
    $this->client->submitForm('Modifier', self::createFormData());
    self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
  }

  /**
   * @return array<string>
   */
  private static function createFormData(
    string $title = 'Nom de la tâche modifiée',
    string $content = 'Contenu de la tâche modifiée'
  ): array {
      return [
          'task[title]' => $title,
          'task[content]' => $content
      ];
  }

  public function findTask(): int
  {
    $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'user1@user.fr']);
    $tasksList = $this->entityManager->getRepository(Task::class)->findBy(['user' => $user]);

    return $tasksList[0]->getId();
  }
}

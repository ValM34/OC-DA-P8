<?php

namespace App\Tests\Controller\Task;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class CreateActionTest extends WebTestCase
{
  private KernelBrowser $client;
  private EntityManagerInterface $entityManager;
  
  protected function setUp(): void
  {
      $this->client = static::createClient();
      $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
  }

  public function testCreateAction(): void
  {
    $user = $this->findUser();
    $this->client->loginUser($user);
    $this->client->request(Request::METHOD_GET, '/tasks/create');
    self::assertResponseIsSuccessful();
    $this->client->submitForm('Ajouter', self::createFormData());
    self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
  }

  /**
   * @return array<string>
   */
  private static function createFormData(
    string $title = 'Nom de la tâche',
    string $content = 'Contenu de la tâche'
  ): array {
      return [
          'task[title]' => $title,
          'task[content]' => $content
      ];
  }

  public function findUser(): User
  {
    $usersList = $this->entityManager->getRepository(User::class)->findAll();

    return $usersList[0];
  }
}

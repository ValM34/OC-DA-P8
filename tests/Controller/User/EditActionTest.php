<?php

namespace App\Tests\Controller\User;

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
  
  protected function setUp(): void
  {
      $this->client = static::createClient();
  }

  public function testEditAction(): void
  {
    $entityManager = $this->client->getContainer()->get(EntityManagerInterface::class);
    $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'user1@admin.fr']);
    $this->client->loginUser($user);
    $this->client->request(Request::METHOD_GET, '/users/' . $user->getId() . '/edit');
    self::assertResponseIsSuccessful();
    $this->client->submitForm('Modifier', self::createFormData());
    self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
  }

  /**
   * @return array<string>
   */
  private static function createFormData(
    string $username = 'Nouveau username',
    string $email = 'user1@admin.fr',
    string $password = 'password'
  ): array {
      return [
          'update_user[username]' => $username,
          'update_user[email]' => $email,
          'update_user[plainPassword][first]' => $password,
          'update_user[plainPassword][second]' => $password,
      ];
  }
}

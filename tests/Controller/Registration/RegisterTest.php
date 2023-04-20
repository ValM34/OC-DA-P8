<?php

declare(strict_types=1);

namespace App\Tests\Registration;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class RegistrationTest extends WebTestCase
{
  public function testRegister(): void
  {
    $client = static::createClient();
    $entityManager = $client->getContainer()->get(EntityManagerInterface::class);
    $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'user1@admin.fr']);
    $client->loginUser($user);
    $client->request(Request::METHOD_GET, '/users/create');
    $crawler = $client->request(Request::METHOD_GET, '/users/create');
    $client->submitForm('Ajouter', self::createFormData());

    $entityManager = $client->getContainer()->get(EntityManagerInterface::class);
    $passwordHasher = $client->getContainer()->get(UserPasswordHasherInterface::class);
    $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'newuser@user.fr']);

    self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
    self::assertResponseRedirects('/users');
    self::assertNotNull($user);
    self::assertTrue($passwordHasher->isPasswordValid($user, 'password'));
    self::assertSame('New user', $user->getUsername());
    self::assertSame('newuser@user.fr', $user->getEmail());
  }

  private static function createFormData(
    string $username = 'New user',
    string $email = 'newuser@user.fr',
    string $password = 'password'
  ): array {
    return [
      'registration_form[username]' => $username,
      'registration_form[email]' => $email,
      'registration_form[plainPassword][first]' => $password,
      'registration_form[plainPassword][second]' => $password,
    ];
  }
}

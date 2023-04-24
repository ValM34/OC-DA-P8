<?php

declare(strict_types=1);

namespace App\Tests\Registration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LoginTest extends WebTestCase
{
  public function testLogin(): void
  {
    $client = static::createClient();
    $client->request(Request::METHOD_GET, '/login');    
    $client->submitForm('Se connecter', self::createFormData());
    self::assertResponseRedirects('/');
    self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
  }

  private static function createFormData(
    string $email = 'user0@admin.fr',
    string $password = 'password'
  ): array {
    return [
      'email' => $email,
      'password' => $password,
    ];
  }
}

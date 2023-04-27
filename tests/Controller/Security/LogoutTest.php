<?php

declare(strict_types=1);

namespace App\Tests\Registration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LogoutTest extends WebTestCase
{
  public function testLogout(): void
  {
    $client = static::createClient();
    $client->request(Request::METHOD_GET, '/logout');
    self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
    $client->followRedirect();
    $this->assertRouteSame('homepage');
  }
}

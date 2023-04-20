<?php

namespace App\Tests\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ListActionTest extends WebTestCase
{
  public function testListAction()
  {
    $client = static::createClient();
    $client->request(Request::METHOD_GET, '/users');
    self::assertResponseIsSuccessful();
  }
}

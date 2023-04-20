<?php

namespace App\Tests\Task;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ListActionTest extends WebTestCase
{
  public function testListAction()
  {
    $client = static::createClient();
    $client->request(Request::METHOD_GET, '/');
    self::assertResponseIsSuccessful();
  }
}

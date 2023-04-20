<?php

namespace App\Tests\Default;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class DefaultControllerTest extends WebTestCase
{
  public function testIndexAction()
  {
    $client = static::createClient();
    $client->request(Request::METHOD_GET, '/');
    self::assertResponseIsSuccessful();
  }
}

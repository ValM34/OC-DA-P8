<?php

namespace App\Tests\Task;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListActionTest extends WebTestCase
{
  public function testListActionIfTaskIsDone()
  {
    $client = static::createClient();
    $client->request(Request::METHOD_GET, '/', ['isDone' => '1']);
    $this->assertTrue($client->getRequest()->getQueryString() === 'isDone=1');
    self::assertResponseIsSuccessful();
    self::assertResponseStatusCodeSame(Response::HTTP_OK);
  }

  public function testListActionIfTaskIsNotDone()
  {
    $client = static::createClient();
    $client->request(Request::METHOD_GET, '/', ['isDone' => '0']);
    $this->assertTrue($client->getRequest()->getQueryString() === 'isDone=0');
    self::assertResponseIsSuccessful();
    self::assertResponseStatusCodeSame(Response::HTTP_OK);
  }
}

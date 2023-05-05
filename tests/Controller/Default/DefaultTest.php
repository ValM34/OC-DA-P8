<?php

namespace App\Tests\Controller\Default;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class DefaultControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }

    public function testIndexAction(): void
    {
        $this->client->request(Request::METHOD_GET, '/');
        self::assertResponseRedirects('/login');

        $user = $this->findUser();
        $this->client->loginUser($user);
        $this->client->request(Request::METHOD_GET, '/');
        self::assertResponseIsSuccessful();
    }

    public function findUser(): User
    {
        $usersList = $this->entityManager->getRepository(User::class)->findAll();

        return $usersList[0];
    }
}

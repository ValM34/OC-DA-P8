<?php

namespace App\Tests\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class ListActionTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }

    public function testListAction(): void
    {
        $this->client->request(Request::METHOD_GET, '/users');
        self::assertResponseRedirects('/login');

        $user = $this->findUserAdmin();
        $this->client->loginUser($user);
        $this->client->request(Request::METHOD_GET, '/users');
        self::assertResponseIsSuccessful();
    }

    public function findUserAdmin(): User
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'user0@admin.fr']);

        return $user;
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Registration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use App\Controller\SecurityController;

final class LogoutTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }

    public function testLogout(): void
    {
        $user = $this->findUser();
        $this->client->loginUser($user);
        $this->client->request(Request::METHOD_GET, '/logout');
        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->client->followRedirect();
        $this->assertRouteSame('homepage');
    }

    public function testLogoutThrowsLogicException(): void
    {
        $controller = new SecurityController(new \Exception('Test exception'));

        $this->expectException(\LogicException::class);
        $controller->logout();
    }

    public function findUser(): User
    {
        $usersList = $this->entityManager->getRepository(User::class)->findAll();

        return $usersList[0];
    }
}

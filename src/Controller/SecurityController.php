<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\UserServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\PasswordRecoveryForm;
use App\Form\PasswordUpdateForm;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
  // LOGIN
  #[Route(path: '/login', name: 'login', methods: ['POST', 'GET'])]
  public function login(AuthenticationUtils $authenticationUtils): Response
  {
    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();
    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
  }

  // LOGOUT
  #[Route(path: '/logout', name: 'logout', methods: ['GET'])]
  public function logout(): void
  {
    throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
  }
}

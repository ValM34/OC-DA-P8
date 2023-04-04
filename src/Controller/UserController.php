<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\AppCustomAuthenticator;

class UserController extends AbstractController
{
  private $dateTimeImmutable;

  public function __construct(private EntityManagerInterface $entityManager, private UserPasswordHasherInterface $userPasswordHasher)
  {
    $this->dateTimeImmutable = new DateTimeImmutable();
  }

  #[Route(path: '/users', name: 'user_list')]
  public function listAction()
  {
    return $this->render('user/list.html.twig', ['users' => $this->entityManager->getRepository(User::class)->findAll()]);
  }

  #[Route(path: '/users/{id}/edit', name: 'user_edit')]
  public function editAction(User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher)
  {
    $form = $this->createForm(RegistrationFormType::class, $user);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // encode the plain password
      $user->setPassword(
        $userPasswordHasher->hashPassword(
          $user,
          $form->get('plainPassword')->getData()
        )
      );

      $this->entityManager->persist($user);
      $this->entityManager->flush();

      $this->addFlash('success', "L'utilisateur a bien été modifié");

      return $this->redirectToRoute('user_list');
    }

    return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
  }
}

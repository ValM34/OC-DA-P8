<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UpdateUserType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Service\UserServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    public function __construct(private UserServiceInterface $userService)
    {
    }

    #[Route(path: '/users', name: 'user_list', methods: ['GET'])]
    public function listAction(): Response
    {
        $users = $this->userService->display();

        return $this->render('user/list.html.twig', ['users' => $users]);
    }

    #[Route(path: '/users/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function editAction(User $user, Request $request): Response
    {
        $this->denyAccessUnlessGranted('update', $user);

        $form = $this->createForm(UpdateUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->update($user, $form->get('plainPassword')->getData());
            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}

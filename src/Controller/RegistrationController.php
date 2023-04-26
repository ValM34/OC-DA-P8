<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserServiceInterface;

class RegistrationController extends AbstractController
{
    private $user;

    public function __construct(
        private UserServiceInterface $userService
    ) {
        $this->user = new User();
    }

    // REGISTER
    #[Route('/users/create', name: 'user_create')]
    public function register(Request $request): Response
    {
        // check for "view" access: calls all voters
        $this->denyAccessUnlessGranted('create', $this->user);

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->create($user, $form->get('plainPassword')->getData(), $request);

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }
}

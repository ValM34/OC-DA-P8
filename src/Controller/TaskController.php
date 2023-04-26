<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;
use App\Service\TaskServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractController
{
    private $dateTimeImmutable;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private TaskServiceInterface $taskService
    ) {
        $this->dateTimeImmutable = new DateTimeImmutable();
    }

    #[Route('/tasks', name: 'task_list', methods: ['GET'])]
    public function listAction(Request $request): Response
    {
        $tasksList = $this->taskService->display($this->getUser(), $request);

        return $this->render('task/list.html.twig', ['tasks' => $tasksList]);
    }

    #[Route('/tasks/create', name: 'task_create', methods: ['GET', 'POST'])]
    public function createAction(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskService->create($task, $this->getUser());
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list', ['isDone' => 'false']);
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route(path: '/tasks/{id}/edit', name: 'task_edit', methods: ['GET', 'POST'])]
    public function editAction(Task $task, Request $request): Response
    {
        $this->denyAccessUnlessGranted('handle', $task);

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskService->update($task);
            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render(
            'task/edit.html.twig',
            [
            'form' => $form->createView(),
            'task' => $task,
            ]
        );
    }

    #[Route(path: '/tasks/{id}/toggle', name: 'task_toggle', methods: ['GET'])]
    public function toggleTaskAction(Task $task, Request $request): Response
    {
        $this->denyAccessUnlessGranted('handle', $task);

        $this->taskService->toggleIsDone($task);

        if ($task->isIsDone()) {
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

            return $this->redirectToRoute('task_list', ['isDone' => 'true']);
        } else {
            $this->addFlash(
                'success',
                sprintf('La tâche %s a bien été marquée comme non terminée.', $task->getTitle())
            );

            return $this->redirectToRoute('task_list', ['isDone' => 'false']);
        }
    }

    #[Route(path: '/tasks/{id}/delete', name: 'task_delete', methods: ['GET'])]
    public function deleteTaskAction(Task $task): Response
    {
        $this->denyAccessUnlessGranted('handle', $task);

        $this->taskService->delete($task);
        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}

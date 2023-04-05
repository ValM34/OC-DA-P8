<?php

namespace App\Service;

use App\Service\TaskServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;
use \DateTimeImmutable;

class TaskService implements TaskServiceInterface
{
  private $dateTimeImmutable;

  public function __construct(
    private EntityManagerInterface $entityManager
  ) {
    $this->dateTimeImmutable = new DateTimeImmutable();
  }

  public function create(Task $task): void
  {
    $date = $this->dateTimeImmutable;
    $task
      ->setIsDone(false)
      ->setCreatedAt($date)
      ->setUpdatedAt($date)
    ;

    $this->entityManager->persist($task);
    $this->entityManager->flush();
  }

  public function update(Task $task): void
  {
    $task
      ->setUpdatedAt($this->dateTimeImmutable)
    ;
    $this->entityManager->flush();
  }

  public function toggleIsDone(Task $task): void
  {
    $task->setIsDone(!$task->isIsDone());
    $this->entityManager->persist($task);
    $this->entityManager->flush();
  }

  public function delete(Task $task): void
  {
    $this->entityManager->remove($task);
    $this->entityManager->flush();
  }
}

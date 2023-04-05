<?php

namespace App\Service;

use App\Entity\Task;

interface TaskServiceInterface
{
  public function create(Task $task): void;
  public function update(Task $task): void;
  public function toggleIsDone(Task $task): void;
  public function delete(Task $task): void;
}

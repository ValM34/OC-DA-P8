<?php

namespace App\Service;

use App\Entity\Task;
use App\Entity\User;

interface TaskServiceInterface
{
  public function create(Task $task, User $user): void;
  public function update(Task $task): void;
  public function toggleIsDone(Task $task): void;
  public function delete(Task $task): void;
}

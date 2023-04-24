<?php

namespace App\Service;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

interface TaskServiceInterface
{
    /**
     * @return array<array-key, Task>
     */
    public function display(User $user, Request $request): array;
    public function create(Task $task, User $user): void;
    public function update(Task $task): void;
    public function toggleIsDone(Task $task): void;
    public function delete(Task $task): void;
}

<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

interface UserServiceInterface
{
    public function display(): array;
    public function create(User $user, string $plainPassword, Request $request): void;
    public function update(User $user, string $plainPassword): void;
    public function define(User $user, string $plainPassword): void;
}

<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // both admin and user can list (filtered in controller)
    }

    public function view(User $user, Task $task): bool
    {
        return $user->hasRole('admin') || $task->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('user');
    }

    public function update(User $user, Task $task): bool
    {
        return $user->hasRole('admin') || $task->user_id === $user->id;
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->hasRole('admin') || $task->user_id === $user->id;
    }

    public function restore(User $user, Task $task): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Task $task): bool
    {
        return $user->hasRole('admin');
    }
}
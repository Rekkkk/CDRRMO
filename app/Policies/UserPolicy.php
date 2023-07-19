<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function generateData(User $user): bool
    {
        return ($user->status === "Active" || $user->position === "President" || $user->position === "Focal") ? true : false;
    }

    public function view(User $user): bool
    {
        return ($user->status === "Active" && auth()->check()) ? true : false;
    }

    public function create(User $user): bool
    {
        return ($user->status === "Active" && auth()->check()) ? true : false;
    }

    public function alter(User $user): bool
    {
        return ($user->status === "Active" && auth()->check()) ? true : false;
    }

    public function alterReport(User $user): bool
    {
        return ($user->status === "Active" && auth()->check()) ? true : false;
    }
}

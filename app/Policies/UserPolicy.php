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

    public function editProfile(User $user): bool
    {
        return ($user->status === "Active" && auth()->check()) ? true : false;
    }

    public function updateOrArchive(User $user): bool
    {
        return ($user->status === "Active" && auth()->check()) ? true : false;
    }

    public function approveOrDecline(User $user): bool
    {
        return ($user->organization === "CDRRMO" && auth()->check()) ? true : false;
    }

    public function removeReport(User $user): bool
    {
        return ($user->organization === "CDRRMO" && auth()->check()) ? true : false;
    }

    public function editNumbers(User $user): bool
    {
        return ($user->status === "Active" && auth()->check()) ? true : false;
    }
}

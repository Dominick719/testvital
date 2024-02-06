<?php

namespace App\Policies;

use App\Models\User;

use App\Models\Publication;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PublicationPolicy
{
    use HandlesAuthorization;

    // https://laravel.com/docs/9.x/authorization#authorizing-resource-controllers

    // https://laravel.com/docs/9.x/authorization#policy-responses

    // Determinar el permiso para el método index
    public function viewAny(User $user)
    {
        return $user->role->slug === "organizador" || $user->role->slug === "administrador" || $user->role->slug === "estudiante";
    }

    // Determinar el permiso para el método show
    public function view(User $user, Publication $report)
    {
        return $user->id === $report->user_id || $user->role->slug === "administrador" || $user->role->slug === "estudiante"
        ? Response::allow()
        : Response::deny("You don't own this report.");
    }

    // Determinar el permiso para el método create
    public function create(User $user)
    {
        return $user->role->slug === "organizador";
    }

    // Determinar el permiso para el método update
    public function update(User $user, Publication $report)
    {
        return $user->id === $report->user_id
        ? Response::allow()
        : Response::deny("You don't own this report.");
    }

    // Determinar el permiso para el método delete
    public function delete(User $user, Publication $report)
    {
        return $user->id === $report->user_id || $user->role->slug === "administrador"
            ? Response::allow()
            : Response::deny("You don't own this report.");
    }
}

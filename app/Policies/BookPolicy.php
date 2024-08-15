<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo('add books')
            ? Response::allow()
            : Response::deny('You do not have permission to add books.', 403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->hasPermissionTo('edit books')
            ? Response::allow()
            : Response::deny('You do not have permission to edit books.', 403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->hasPermissionTo('delete books')
            ? Response::allow()
            : Response::deny('You do not have permission to delete books.', 403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): Response
    {
        return $user->hasPermissionTo('delete books')
            ? Response::allow()
            : Response::deny('You do not have permission to edit books.', 403);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): Response
    {
        return $user->hasPermissionTo('delete books')
            ? Response::allow()
            : Response::deny('You do not have permission to edit books.', 403);
    }
}

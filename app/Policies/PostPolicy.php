<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        //
    }

    public function modify(Employer $employer, Post $post): Response
    {
        // Allow access if the post is owned by employer
        return $employer->id === $post->employer_id ? Response::allow() : Response::deny('You do not own this job posting.');
    }

    // public function denyEmployee(Employee $employee, Post $post): Response
    // {
    //     // Do not allow access for creating jobs if employee
    //     return $employee->id === $post->employer_id ? Response::allow() : Response::deny('You do not own this job posting.');
    // }
}

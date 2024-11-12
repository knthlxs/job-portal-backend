<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApplicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

   /** * Determine whether the employer can view the application. */
    public function view(Employer $employer, Application $application) { 
        // Allow access if the application is owned by the employer's job post 
        return $employer->id === $application->post->employer_id ? $this->allow() : $this->deny('You do not own this job application.');
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
    public function update(User $user, Application $application): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Application $application): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Application $application): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Application $application): bool
    {
        //
    }

    public function modify(Employer $employer, Application $application): Response
    {
        // Allow access if the application is owned by employer
        return $employer->id === $application->post_id ? Response::allow() : Response::deny('You do not own this job application.');
    }
}

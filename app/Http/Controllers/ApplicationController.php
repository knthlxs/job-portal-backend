<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller implements HasMiddleware
{
    // Need to add this middleware for authentication
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index'])
        ];
    }
    // Check if the user who is making a request is an employer
    public function checkEmployer()
    {
        $user = Auth::user(); // Get the user that is authenticated 
        if (!$user) {
            return ['error' => 'Unauthorized'];
        }
        if ($user->user_type !== 'employer') { // Ensure the user is an employer
            return ['error' => 'Only employers can perform this request'];
        }
        return null; // Indicate that the check passed
    }

    // Check if the user who is making a request is an employer
    public function checkEmployee()
    {
        $user = Auth::user(); // Get the user that is authenticated 
        if (!$user) {
            return ['error' => 'Unauthorized'];
        }
        if ($user->user_type !== 'employee') { // Ensure the user is an employer
            return ['error' => 'Only employees can perform this request'];
        }
        return null; // Indicate that the check passed
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Application::with('employee', 'post')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if user is authorized
        $response = $this->checkEmployee();
        if ($response) {
            return $response; // Return the error response if the user is not authorized
        }

        $employee = Auth::user(); // Retrieve the authenticated employee user

        // Validate the request 
        $data = $request->validate(['post_id' => 'required|exists:posts,id',]);

        // Check if the employee has already applied for this post 
        $existingApplication = Application::where('employee_id', $employee->id)->where('post_id', $data['post_id'])->first();
        if ($existingApplication) {
            return ['error' => 'You have already applied for this job post.'];
        }
        // Create the application
        $application = Application::create(
            [
                'employee_id' => $employee->id,
                'post_id' => $request->post_id,
                'status' => 'pending',
                'applied_at' => now()
            ]
        );

        return ['application' => $application, 'employee' => $employee];
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        // // Check if user is authorized
        $response = $this->checkEmployer();
        if ($response) {
            return $response; // Return the error response if the user is not authorized
        }
        Gate::authorize('modify', $application); // Employer who owns the job post can access who apply in the job post

        // $employee = Auth::user(); // Retrieve the authenticated employee user
        return ['application' => $application];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        // Check if user is authorized
        $response = $this->checkEmployer();
        if ($response) {
            return $response; // Return the error response if the user is not authorized
        }
        Gate::authorize('modify', $application);

        // Validate the request, ensuring `post_id` exists and `status` is valid
        $data = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'status' => 'required|string|in:pending,approved,rejected',
        ]);

        // Update the application with the new status
        $application->update($data);

        // Return a response confirming the update
        return [
            'application' => $application,
            'message' => 'Application status updated successfully.'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        // Check if user is authorized
        $response = $this->checkEmployer();
        if ($response) {
            return $response; // Return the error response if the user is not authorized
        }
        Gate::authorize('modify', $application);
        $application->delete();
        return ['message' => 'Job application was deleted successfully.'];
    }
}

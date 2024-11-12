<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller implements HasMiddleware
{
    // Need to add this middleware for authentication
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    // Check if the user who is making a request is an employer
    public function checkUser()
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::with('employer')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if user is authorized
        $response = $this->checkUser();
        if ($response) {
            return $response; // Return the error response if the user is not authorized
        }

        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'requirements' => 'required',
            'salary' => 'required',
        ]);
        // user() method is the user that is currently authenticated
        // user()->post() === Employer::post()
        $post = $request->user()->post()->create($data);

        return ['post' => $post, 'user' => $post->user];
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return ['post' => $post, 'employer' => $post->employer];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Check if user is authorized
        $response = $this->checkUser();
        if ($response) {
            return $response; // Return the error response if the user is not authorized
        }

        Gate::authorize('modify', $post);
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'requirements' => 'required',
            'salary' => 'required',
        ]);
        // user() method is the user that is currently authenticated
        $post->update($data);

        return ['post' => $post, 'user' => $post->user];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Check if user is authorized
        $response = $this->checkUser();
        if ($response) {
            return $response; // Return the error response if the user is not authorized
        } 

        Gate::authorize('modify', $post);
        $post->delete();
        return ['message' => 'Job post was deleted.'];
    }
}

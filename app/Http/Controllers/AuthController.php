<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        // Create Employee User if user_type is Employee else create Employer
        if ($request->user_type === 'employee') {
            // Validate data
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:employees,email',
                'password' => 'required|min:5',
                'user_type' => 'required',
                'position' => 'required|string|max:255',
                'salary' => 'required|numeric|min:0',
                'resume' => 'required',
                'skills' => 'required|string',
                'experience_years' => 'required|integer|min:0',
            ]);


            $employee = Employee::create($data); // Create Employee
            $token = $employee->createToken($request->name); // Create token from name field. This token will be used to authorize api calls.

            // Return json data
            return [
                'employee' => $employee,
                'token' => $token
            ];
        } else {


            // Validate data
            $data = $request->validate([
                'company_name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:employers,email',
                'password' => 'required|min:5',
                'user_type' => 'required',
                'website' => 'required|string|max:255',
                'contact_number' => 'required|string|max:20',
                'company_address' => 'required|string|max:255',
                'industry_type' => 'required|string|max:255'
            ]);


            $employer = Employer::create($data); // Create Employer
            $token = $employer->createToken($request->company_name); // Create token from company_name field. This token will be used to authorize api calls.

            // Return json data
            return [
                'employer' => $employer,
                'token' => $token
            ];
        }
    }

    public function login(Request $request)
    {

        // Validate data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $employee = Employee::where('email', $request->email)->first(); // Check if there is an of email of employee from database to user input. This means that employee user is found.
        $user_type = 'employee'; // Set user_type to employee for conditions

        if (!$employee) { // This means that no employee user is found. So we assume that the user is an employer.
            $user_type = 'employer'; // Set user_type to employer for conditions
            $employer = Employer::where('email', $request->email)->first(); // Check if there is an email of employer from database with the inputted email
        }

        if ($user_type === 'employee') {
            if (!$employee || !Hash::check($request->password, $employee->password)) {
                return [
                    'errors' => [
                        'email' => ['The provided credentials are incorrect.']
                    ]
                ];
            }
            $token = $employee->createToken($employee->name)->plainTextToken; // This token will be use to authorize API calls
            // Return json data
            return [
                'employee' => $employee,
                'token' => $token
            ];
        } else {
            if (!$employer || !Hash::check($request->password, $employer->password)) {
                return [
                    'errors' => [
                        'email' => ['The provided credentials are incorrect.']
                    ]
                ];
            }
            $token = $employer->createToken($employer->company_name)->plainTextToken; // This token will be use to authorize API calls
            // Return json data
            return [
                'employer' => $employer,
                'token' => $token
            ];
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); // Delete the token of authenticated user
        return ['message' => 'You are logged out'];
    }
}

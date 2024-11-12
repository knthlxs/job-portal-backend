<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Employee;
use App\Models\Employer;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Create multiple employers 
        Employer::insert([
            [
                'company_name' => 'NextGen Technologies',
                'email' => 'contact@nextgentech.com',
                'password' => Hash::make('nextgensecure123'),
                'website' => 'https://nextgentech.com',
                'contact_number' => '987-654-3210',
                'company_address' => '456 Future Lane, Innovation Park, NY 10001',
                'industry_type' => 'Technology',
                'user_type' => 'employer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'Tech Innovators Inc.',
                'email' => 'info@techinnovators.com',
                'password' => Hash::make('securepassword123'),
                'website' => 'https://techinnovators.com',
                'contact_number' => '123-456-7890',
                'company_address' => '123 Innovation Drive, Tech City, CA 94043',
                'industry_type' => 'Information Technology',
                'user_type' => 'employer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'Global Solutions Ltd.',
                'email' => 'hr@globalsolutions.com',
                'password' => Hash::make('globalpass123'),
                'website' => 'https://globalsolutions.com',
                'contact_number' => '456-123-7890',
                'company_address' => '789 Business Ave, Corporate City, TX 75201',
                'industry_type' => 'Consulting',
                'user_type' => 'employer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create multiple employees
        Employee::insert([
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password123'),
                'position' => 'Software Engineer',
                'salary' => 75000.00,
                'resume' => 'resume.pdf',
                'skills' => 'PHP, Laravel, JavaScript, HTML, CSS',
                'experience_years' => 5,
                'user_type' => 'employee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('password123'),
                'position' => 'Product Manager',
                'salary' => 85000.00,
                'resume' => 'resume.pdf',
                'skills' => 'Project Management, Agile, Scrum',
                'experience_years' => 7,
                'user_type' => 'employee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'password' => Hash::make('password123'),
                'position' => 'Data Analyst',
                'salary' => 65000.00,
                'resume' => 'resume.pdf',
                'skills' => 'Data Analysis, SQL, Python',
                'experience_years' => 3,
                'user_type' => 'employee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create multiple posts for employers
        Post::insert([
            [
                'employer_id' => 1,
                'title' => 'Data Scientist',
                'description' => 'NextGen Technologies is seeking a talented Data Scientist to join our analytics team.',
                'requirements' => 'Master\'s degree in Data Science or related field. 3+ years of experience.',
                'salary' => 105000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employer_id' => 2,
                'title' => 'Frontend Developer',
                'description' => 'Tech Innovators Inc. is looking for a Frontend Developer skilled in React and Vue.',
                'requirements' => 'Bachelor\'s degree in Computer Science or related field. 2+ years of experience.',
                'salary' => 90000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employer_id' => 3,
                'title' => 'Business Analyst',
                'description' => 'Global Solutions Ltd. seeks an experienced Business Analyst for client projects.',
                'requirements' => 'Bachelor\'s degree in Business or related field. 5+ years of experience.',
                'salary' => 95000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create multiple applications from employees to posts
        Application::insert([
            [
                'post_id' => 1,
                'employee_id' => 1,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 2,
                'employee_id' => 2,
                'status' => 'interview',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 3,
                'employee_id' => 3,
                'status' => 'hired',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

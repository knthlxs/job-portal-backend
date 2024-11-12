1. Clone the Repository
git clone https://github.com/knthlxs/job-portal-backend.git
cd job-portal-backend
2. Install PHP and Composer

3. Install Laravel Dependencies
~ composer install

4. Set Up Environment Configuration
~ cp .env.example .env

5. Generate Application Key
Generate the application key, which is used by Laravel for encryption:
~ php artisan key:generate

6. Configure Database
.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_portal
DB_USERNAME=root
DB_PASSWORD=password

7. Run Migrations
After setting up the database, run the migrations to create the necessary tables:
~ php artisan migrate

8. Run the Application
Start the Laravel development server:
~ php artisan serve

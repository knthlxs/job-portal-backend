<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Application extends Model
{
    use HasApiTokens, HasFactory;
    protected $fillable = ['employee_id', 'post_id', 'status', 'applied_at',];
     
    public function employee()
    {
        return $this->belongsTo(Employee::class); // Relationship to Employee
    }
     
    public function post()
    {
        return $this->belongsTo(Post::class); // Relationship to Post
    }
}

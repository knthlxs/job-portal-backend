<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    use HasApiTokens, HasFactory;
    protected $fillable = [
        'employer_id', 
        'title', 
        'description', 
        'requirements', 
        'salary',
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class); // Relationship to Employer
    }

    public function applications()
    {
        return $this->hasMany(Application::class); // Relationship to Applications
    }
}

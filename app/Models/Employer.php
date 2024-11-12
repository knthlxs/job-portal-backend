<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Employer extends Model
{
    use HasApiTokens, HasFactory;
    protected $fillable = [
        'company_name',
        'email',
        'password',
        'user_type',
        'website',
        'contact_number',
        'company_address',
        'industry_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function post() {
        return $this->hasMany(Post::class);
     }

     public function applications()
{
    return $this->hasManyThrough(Application::class, Post::class);
}

}

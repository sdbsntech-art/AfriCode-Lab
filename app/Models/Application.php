<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role_applied',
        'domain_expertise',
        'experience_years',
        'bio',
        'github_url',
        'linkedin_url',
        'cv_path',
        'status',
        'admin_notes',
    ];
}

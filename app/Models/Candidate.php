<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'birthday', 'education', 'experience', 'last_position', 'applied_position', 'top_skills', 'email', 'phone', 'resume'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'full_name', 'title', 'description', 'profile_image',
        'phone', 'email', 'address', 'cv_file',
    ];
}

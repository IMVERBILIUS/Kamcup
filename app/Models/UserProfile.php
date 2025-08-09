<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'profile_photo', 'name', 'email', 'birthdate',
        'gender', 'phone_number', 'social_media',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

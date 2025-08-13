<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'google_id'];

    protected $hidden = ['password', 'remember_token'];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAuthor()
    {
        return $this->role === 'author';
    }

    public function isReader()
    {
        return $this->role === 'reader';
    }

    public function profile() {
        return $this->hasOne(UserProfile::class);
    }

    // --- ADJUSTMENT FOR TEAM RELATIONSHIP ---
    // A user can only have ONE team (owns one team)
    // Specify 'user_id' as the foreign key in the 'teams' table
    public function team() {
        return $this->hasOne(Team::class, 'user_id'); // <-- THIS IS THE KEY CHANGE
    }
    // --- END ADJUSTMENT ---

    public function articles() {
        return $this->hasMany(Article::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function registeredTournaments()
    {
        return $this->hasMany(TournamentRegistration::class);
    }

    public function hostApplications()
    {
        return $this->hasMany(TournamentHostRequest::class);
    }

    // TAMBAH RELASI KE DONATIONS
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}

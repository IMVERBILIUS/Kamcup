<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentRule extends Model
{
    protected $fillable = ['tournament_id', 'rule_text'];

    public function tournament() {
        return $this->belongsTo(Tournament::class);
    }
}

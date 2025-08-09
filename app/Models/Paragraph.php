<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{

    protected $fillable = [
        'subheading_id', 'content',
    ];

    public function subheading()
    {
        return $this->belongsTo(Subheading::class, 'subheading_id', 'id');

    }
}

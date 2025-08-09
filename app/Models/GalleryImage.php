<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id', 'image'
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}



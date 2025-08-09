<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GallerySubtitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id', 'order_number', 'subtitle'
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function contents()
    {
        return $this->hasMany(GalleryContent::class);
    }
}

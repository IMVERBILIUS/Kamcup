<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_subtitle_id', 'order_number', 'content'
    ];

    public function subtitle()
    {
        return $this->belongsTo(GallerySubtitle::class, 'gallery_subtitle_id');
    }
}




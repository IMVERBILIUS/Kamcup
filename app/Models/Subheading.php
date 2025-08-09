<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Subheading extends Model
{


    protected $fillable = [
        'article_id', 'title','order_number',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    public function paragraphs()
    {
        return $this->hasMany(Paragraph::class, 'subheading_id', 'id');
    }
}

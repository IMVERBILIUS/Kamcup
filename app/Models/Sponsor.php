<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = ['name', 'logo', 'sponsor_size', 'description', 'order_number'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($sponsor) {
            // Set order_number otomatis jika belum diisi
            if (is_null($sponsor->order_number)) {
                $sponsor->order_number = Sponsor::max('order_number') + 1;
            }
        });
    }

    public function tournaments() {
        return $this->belongsToMany(Tournament::class, 'sponsor_tournament');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',      // TAMBAH INI - Relasi ke user yang login
        'name_brand',
        'email', 
        'phone_whatsapp',
        'event_name',
        'donation_type',
        'sponsor_type',
        'message',
        'benefits',
        'status'
    ];

    protected $casts = [
        'donation_type' => 'string',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // TAMBAH RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeSponsors($query)
    {
        return $query->where('donation_type', 'sponsor');
    }

    public function scopeDonatur($query)
    {
        return $query->where('donation_type', 'donatur');
    }

    // Accessors
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d F Y H:i');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge badge-warning">Pending</span>',
            'approved' => '<span class="badge badge-success">Disetujui</span>',
            'rejected' => '<span class="badge badge-danger">Ditolak</span>',
        ];
        
        return $badges[$this->status] ?? $badges['pending'];
    }

    // Methods
    public function approve()
    {
        $this->status = 'approved';
        return $this->save();
    }

    public function reject()
    {
        $this->status = 'rejected';
        return $this->save();
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isSponsor()
    {
        return $this->donation_type === 'sponsor';
    }

    public function isDonatur()
    {
        return $this->donation_type === 'donatur';
    }

    // Auto-set benefits based on sponsor_type
    protected static function booted()
    {
        static::creating(function ($donation) {
            if ($donation->donation_type === 'sponsor' && $donation->sponsor_type) {
                $donation->benefits = static::getSponsorBenefits($donation->sponsor_type);
            }
        });

        static::updating(function ($donation) {
            if ($donation->donation_type === 'sponsor' && $donation->sponsor_type) {
                $donation->benefits = static::getSponsorBenefits($donation->sponsor_type);
            }
        });
    }

    public static function getSponsorBenefits($sponsorType)
    {
        $benefits = [
            'XXL' => [
                'Logo perusahaan di Web',
                'Mendapatkan seluruh kontraprestasi yang didapatkan oleh sponsor khusus',
                'Booth khusus di area event',
                'Branding di semua media promosi',
                'Merchandise khusus',
                'Sertifikat apresiasi'
            ],
            'XL' => [
                'Logo perusahaan di Web',
                'Mendapatkan seluruh kontraprestasi yang didapatkan oleh sponsor khusus',
                'Branding di media promosi utama',
                'Merchandise khusus'
            ],
            'L' => [
                'Logo perusahaan di Web',
                'Mendapatkan kontraprestasi sponsor',
                'Branding di beberapa media promosi'
            ],
            'M' => [
                'Logo perusahaan di Web',
                'Mendapatkan kontraprestasi dasar'
            ]
        ];

        if (isset($benefits[$sponsorType])) {
            return implode("\n", array_map(fn($benefit) => "- $benefit", $benefits[$sponsorType]));
        }

        return null;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TournamentRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'team_id',
        'user_id',
        'status',
        'registration_date',
        'rejection_reason',
        'payment_status',
        'payment_proof',
    ];

    protected $casts = [
        'registration_date' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_REJECTED = 'rejected';

    const PAYMENT_STATUS_UNPAID = 'unpaid';
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_VERIFIED = 'verified';

    /**
     * Get the tournament this registration belongs to
     */
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Get the team for this registration
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the user (captain) who made this registration
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk mendapatkan registrasi yang dikonfirmasi
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    /**
     * Scope untuk mendapatkan registrasi yang pending
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope untuk mendapatkan registrasi yang ditolak
     */
    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    /**
     * Check if registration is confirmed
     */
    public function isConfirmed()
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    /**
     * Check if registration is pending
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if registration is rejected
     */
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Get status badge class for display
     */
    public function getStatusBadgeClass()
    {
        switch ($this->status) {
            case self::STATUS_CONFIRMED:
                return 'badge bg-success';
            case self::STATUS_PENDING:
                return 'badge bg-warning';
            case self::STATUS_REJECTED:
                return 'badge bg-danger';
            default:
                return 'badge bg-secondary';
        }
    }

    /**
     * Get formatted status text
     */
    public function getStatusText()
    {
        switch ($this->status) {
            case self::STATUS_CONFIRMED:
                return 'Dikonfirmasi';
            case self::STATUS_PENDING:
                return 'Menunggu';
            case self::STATUS_REJECTED:
                return 'Ditolak';
            default:
                return 'Unknown';
        }
    }
}
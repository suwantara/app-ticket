<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Passenger extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'type',
        'id_number',
        'id_type',
        'birth_date',
        'gender',
        'nationality',
        'ticket_code',
        'checked_in',
        'checked_in_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'checked_in' => 'boolean',
        'checked_in_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($passenger) {
            if (empty($passenger->ticket_code)) {
                $passenger->ticket_code = self::generateTicketCode();
            }
        });
    }

    public static function generateTicketCode(): string
    {
        do {
            $code = 'P' . strtoupper(Str::random(8));
        } while (self::where('ticket_code', $code)->exists());

        return $code;
    }

    // Relations
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Accessors
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'adult' => 'Dewasa',
            'child' => 'Anak-anak',
            'infant' => 'Bayi',
            default => $this->type,
        };
    }

    public function getGenderLabelAttribute(): string
    {
        return match($this->gender) {
            'male' => 'Laki-laki',
            'female' => 'Perempuan',
            default => '-',
        };
    }

    // Helpers
    public function checkIn(): void
    {
        $this->update([
            'checked_in' => true,
            'checked_in_at' => now(),
        ]);
    }
}

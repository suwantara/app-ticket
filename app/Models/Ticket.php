<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Ticket extends Model
{
    protected $fillable = [
        'order_id',
        'passenger_id',
        'ticket_number',
        'qr_code',
        'qr_code_path',
        'status',
        'valid_from',
        'valid_until',
        'used_at',
        'used_by',
        'notes',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'used_at' => 'datetime',
    ];

    // Boot method for auto-generating ticket number and QR code
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = self::generateTicketNumber();
            }
            if (empty($ticket->qr_code)) {
                $ticket->qr_code = self::generateQrCode();
            }
        });
    }

    /**
     * Generate unique ticket number
     */
    public static function generateTicketNumber(): string
    {
        $prefix = 'TKT';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(5));
        $number = "{$prefix}-{$date}-{$random}";

        // Ensure uniqueness
        while (self::where('ticket_number', $number)->exists()) {
            $random = strtoupper(Str::random(5));
            $number = "{$prefix}-{$date}-{$random}";
        }

        return $number;
    }

    /**
     * Generate unique QR code string
     */
    public static function generateQrCode(): string
    {
        $code = 'QR' . now()->format('YmdHis') . strtoupper(Str::random(8));

        // Ensure uniqueness
        while (self::where('qr_code', $code)->exists()) {
            $code = 'QR' . now()->format('YmdHis') . strtoupper(Str::random(8));
        }

        return $code;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUsed($query)
    {
        return $query->where('status', 'used');
    }

    public function scopeValid($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            });
    }

    public function scopeForOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    // Relations
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function passenger(): BelongsTo
    {
        return $this->belongsTo(Passenger::class);
    }

    // Accessors
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active' => 'Aktif',
            'used' => 'Sudah Digunakan',
            'cancelled' => 'Dibatalkan',
            'expired' => 'Kadaluarsa',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'active' => 'success',
            'used' => 'info',
            'cancelled' => 'danger',
            'expired' => 'warning',
            default => 'gray',
        };
    }

    public function getQrCodeUrlAttribute(): ?string
    {
        if ($this->qr_code_path) {
            return asset('storage/' . $this->qr_code_path);
        }
        return null;
    }

    // Helpers
    public function isValid(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->valid_until && $this->valid_until < now()) {
            return false;
        }

        return true;
    }

    public function isUsed(): bool
    {
        return $this->status === 'used';
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired' ||
            ($this->valid_until && $this->valid_until < now());
    }

    public function canBeUsed(): bool
    {
        if (!$this->isValid() || $this->isUsed()) {
            return false;
        }
        
        // Check if travel date is today (or allow some flexibility)
        $travelDate = $this->order->travel_date;
        $today = now()->startOfDay();
        
        // Allow ticket to be used on travel date
        return $travelDate->startOfDay()->equalTo($today);
    }

    /**
     * Mark ticket as used
     */
    public function markAsUsed(?string $usedBy = null): bool
    {
        if (!$this->canBeUsed()) {
            return false;
        }

        $this->update([
            'status' => 'used',
            'used_at' => now(),
            'used_by' => $usedBy,
        ]);

        return true;
    }

    /**
     * Cancel the ticket
     */
    public function cancel(?string $reason = null): void
    {
        $this->update([
            'status' => 'cancelled',
            'notes' => $reason,
        ]);
    }

    /**
     * Check if ticket is for today's travel
     */
    public function isTodayTravel(): bool
    {
        return $this->order->travel_date->isToday();
    }

    /**
     * Get validation result
     */
    public function validate(): array
    {
        if ($this->status === 'used') {
            return [
                'valid' => false,
                'message' => 'Tiket sudah digunakan pada ' . $this->used_at->format('d M Y H:i'),
                'code' => 'USED',
            ];
        }

        if ($this->status === 'cancelled') {
            return [
                'valid' => false,
                'message' => 'Tiket telah dibatalkan',
                'code' => 'CANCELLED',
            ];
        }

        if ($this->status === 'expired' || $this->isExpired()) {
            return [
                'valid' => false,
                'message' => 'Tiket telah kadaluarsa',
                'code' => 'EXPIRED',
            ];
        }

        if (!$this->order->isPaid()) {
            return [
                'valid' => false,
                'message' => 'Pembayaran belum dikonfirmasi',
                'code' => 'UNPAID',
            ];
        }

        return [
            'valid' => true,
            'message' => 'Tiket valid',
            'code' => 'VALID',
        ];
    }
}

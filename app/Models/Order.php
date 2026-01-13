<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'schedule_id',
        'travel_date',
        'passenger_count',
        'total_amount',
        'contact_name',
        'contact_email',
        'contact_phone',
        'status',
        'payment_status',
        'payment_method',
        'payment_token',
        'payment_url',
        'paid_at',
        'expired_at',
        'notes',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'total_amount' => 'integer',
        'passenger_count' => 'integer',
    ];

    // Boot method for auto-generating order number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
            if (empty($order->expired_at)) {
                $order->expired_at = now()->addHours(2);
            }
        });
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'TKT';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(6));

        return "{$prefix}{$date}{$random}";
    }

    /**
     * Get the route key for the model.
     * Using order_number instead of id for security (prevent IDOR attacks)
     */
    public function getRouteKeyName(): string
    {
        return 'order_number';
    }

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function passengers(): HasMany
    {
        return $this->hasMany(Passenger::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    // Accessors
    public function getTotalAmountFormattedAttribute(): string
    {
        return 'Rp '.number_format($this->total_amount, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'paid' => 'Dibayar',
            'cancelled' => 'Dibatalkan',
            'completed' => 'Selesai',
            'refunded' => 'Dikembalikan',
            default => $this->status,
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'unpaid' => 'Belum Bayar',
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Lunas',
            'failed' => 'Gagal',
            'expired' => 'Kadaluarsa',
            'refunded' => 'Dikembalikan',
            default => $this->payment_status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'confirmed' => 'info',
            'paid' => 'success',
            'cancelled' => 'danger',
            'completed' => 'success',
            'refunded' => 'gray',
            default => 'gray',
        };
    }

    public function getPaymentStatusColorAttribute(): string
    {
        return match ($this->payment_status) {
            'unpaid' => 'gray',
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'expired' => 'danger',
            'refunded' => 'info',
            default => 'gray',
        };
    }

    // Helpers
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isExpired(): bool
    {
        return $this->expired_at && $this->expired_at < now() && ! $this->isPaid();
    }

    public function canBePaid(): bool
    {
        return in_array($this->payment_status, ['unpaid', 'pending', 'failed'])
            && ! $this->isExpired()
            && $this->status !== 'cancelled';
    }

    public function markAsPaid(?string $paymentMethod = null): void
    {
        $this->update([
            'status' => 'paid',
            'payment_status' => 'paid',
            'payment_method' => $paymentMethod ?? $this->payment_method,
            'paid_at' => now(),
        ]);
    }

    public function cancel(): void
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }

    /**
     * Mark order as expired
     */
    public function markAsExpired(): void
    {
        $this->update([
            'status' => 'cancelled',
            'payment_status' => 'expired',
        ]);
    }

    /**
     * Get remaining time until expiration in seconds
     */
    public function getRemainingTimeAttribute(): int
    {
        if (!$this->expired_at || $this->isPaid()) {
            return 0;
        }

        $remaining = $this->expired_at->diffInSeconds(now(), false);
        return max(0, -$remaining);
    }

    /**
     * Get formatted remaining time (e.g., "01:30:45")
     */
    public function getRemainingTimeFormattedAttribute(): string
    {
        $seconds = $this->remaining_time;

        if ($seconds <= 0) {
            return '00:00:00';
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }

    /**
     * Get expiration datetime formatted
     */
    public function getExpiredAtFormattedAttribute(): string
    {
        return $this->expired_at?->translatedFormat('d M Y, H:i') ?? '-';
    }

    // Scopes

    /**
     * Scope for pending payment orders
     */
    public function scopePendingPayment($query)
    {
        return $query->whereIn('payment_status', ['unpaid', 'pending', 'failed'])
            ->whereNotIn('status', ['cancelled', 'completed', 'refunded']);
    }

    /**
     * Scope for expired orders (time passed but not yet marked)
     */
    public function scopeNeedsExpiration($query)
    {
        return $query->pendingPayment()
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', now());
    }

    /**
     * Scope for active (not cancelled/expired) orders
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['cancelled', 'refunded'])
            ->where('payment_status', '!=', 'expired');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // ← THIS IS THE CORRECT IMPORT

class PaymentMethods extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    protected $fillable = [
        'method_name',
        'slug',
        'description',
        'account_holder',
        'account_number',
        'qr_code',
        'instructions',
        'active',
        'sort_order',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Auto-generate slug from method_name
    protected static function booted()
    {
        static::creating(function ($method) {
            $method->slug = Str::slug($method->method_name); // Now works!
        });

        static::updating(function ($method) {
            if ($method->isDirty('method_name')) {
                $method->slug = Str::slug($method->method_name);
            }
        });
    }

    // Helper: Full public URL for QR code
    public function getQrCodeUrlAttribute()
    {
        if (!$this->qr_code) return null;
        return asset(str_replace('public/', 'storage/', $this->qr_code));
    }

    // Optional: Scope for active methods
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}

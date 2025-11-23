<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Enrollment extends Model
{
    protected $fillable = [
        'course_id',
        'payment_method_id',
        'full_name',
        'email',
        'phone',
        'reference_code',
        'screenshot_path',
        'screenshot_url',
        'amount_paid',
        'password',
        'plain_password',
        'status',
        'enrolled_at',
    ];

    protected $hidden = [
        'password', // Never expose hashed password
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'amount_paid' => 'decimal:0',
    ];

    // ==============================================================
    // RELATIONSHIPS
    // ==============================================================

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethods::class, 'payment_method_id');
    }

    // Optional: if you have a User model for students later
    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'email', 'email');
    // }

    // ==============================================================
    // ACCESSORS & MUTATORS
    // ==============================================================

    // Auto generate full screenshot URL
    public function getScreenshotUrlAttribute($value)
    {
        if ($value) {
            return $value;
        }

        return $this->screenshot_path
            ? Storage::url($this->screenshot_path)
            : null;
    }

    // Optional: Format amount with NPR
    public function getFormattedAmountAttribute(): string
    {
        return 'NPR ' . number_format($this->amount_paid);
    }

    // Optional: Status badge text
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            default    => 'Pending',
        };
    }

    // Optional: Status color for frontend
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'success',
            'rejected' => 'danger',
            default    => 'warning',
        };
    }

    // ==============================================================
    // SCOPES (Optional but useful)
    // ==============================================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeForCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }
}

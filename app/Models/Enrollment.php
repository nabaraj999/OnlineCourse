<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Foundation\Auth\User as AuthenticatableBase;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Enrollment extends AuthenticatableBase implements Authenticatable
{
    use AuthenticatableTrait, Notifiable;

    protected $table = 'enrollments'; // Important if table name ≠ class name

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
        'password',
        'remember_token',
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

    // ==============================================================
    // ACCESSORS & MUTATORS
    // ==============================================================

    public function getScreenshotUrlAttribute($value)
    {
        if ($value) {
            return $value;
        }

        return $this->screenshot_path
            ? Storage::url($this->screenshot_path)
            : null;
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'NPR ' . number_format($this->amount_paid);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            default    => 'Pending',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'success',
            'rejected' => 'danger',
            default    => 'warning',
        };
    }

    // ==============================================================
    // SCOPES
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

    public function canLogIn(): bool
    {
        return $this->status === 'approved';
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'email', 'email');
        // OR if you have a proper user_id foreign key:
        // return $this->hasMany(Enrollment::class);
    }
}

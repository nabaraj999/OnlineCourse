<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Foundation\Auth\User as AuthenticatableBase;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Enrollment extends AuthenticatableBase implements Authenticatable
{
    use AuthenticatableTrait, Notifiable;

    protected $table = 'enrollments';

    protected $fillable = [
        'course_id', 'payment_method_id', 'full_name', 'email', 'phone',
        'reference_code', 'screenshot_path', 'screenshot_url', 'amount_paid',
        'password', 'plain_password', 'status', 'enrolled_at'
    ];

    protected $hidden = ['password', 'remember_token', 'plain_password'];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'approved_at' => 'datetime',
        'amount_paid' => 'decimal:2',
    ];

    // Relationships
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethods::class, 'payment_method_id');
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    // This gets all other enrollments (including current) by same email
    public function allEnrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'email', 'email');
    }

    public function suggestions(): HasMany
    {
        return $this->hasMany(Suggestion::class, 'enrollment_id');
    }

    // Accessors
    public function getScreenshotUrlAttribute($value)
    {
        return $value ?? ($this->screenshot_path ? Storage::url($this->screenshot_path) : null);
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'NPR ' . number_format($this->amount_paid);
    }

    public function canLogIn(): bool
    {
        return $this->status === 'approved';
    }
}

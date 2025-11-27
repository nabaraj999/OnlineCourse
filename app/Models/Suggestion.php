<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suggestion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor: Nice status badge
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending'   => '<span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pending</span>',
            'reviewed'  => '<span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Reviewed</span>',
            'resolved'  => '<span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Resolved</span>',
            default     => '<span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Unknown</span>',
        };
    }

    // Accessor: Formatted submission date
    public function getSubmittedAtAttribute()
    {
        return $this->created_at->format('d M Y, h:i A');
    }
    public function enrollment(): BelongsTo
{
    return $this->belongsTo(Enrollment::class, 'enrollment_id');
}
}


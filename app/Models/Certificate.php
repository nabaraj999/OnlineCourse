<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'is_issued' => 'boolean',
        'issued_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Auto generate certificate number
    public static function boot()
    {
        parent::boot();
        static::creating(function ($certificate) {
            if (!$certificate->certificate_number) {
                $certificate->certificate_number = 'CERT-' . date('Y') . '-' . str_pad(Certificate::count() + 1, 5, '0', STR_PAD_LEFT);
            }
        });
    }
}

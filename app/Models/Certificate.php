<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Certificate extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_issued'     => 'boolean',
        'issued_at'     => 'datetime',
        'completed_at'  => 'datetime',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($certificate) {
            if (!$certificate->certificate_number) {
                $certificate->certificate_number = $certificate->generateUniqueNumber();
            }
        });
    }

    public function generateUniqueNumber()
    {
        $year = now()->format('Y');

        return DB::transaction(function () use ($year) {
            // Get highest ID from this year and increment
            $last = static::whereYear('created_at', $year)
                ->lockForUpdate()
                ->max('id');

            $number = str_pad(($last ?? 0) + 1, 6, '0', STR_PAD_LEFT);

            return "CERT-{$year}-{$number}";
        });
    }
}

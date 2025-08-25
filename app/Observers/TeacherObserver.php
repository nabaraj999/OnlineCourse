<?php

namespace App\Observers;

use App\Mail\TeacherApprovalNotification;
use App\Mail\TeacherCreateNotification;
use App\Models\Teacher;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TeacherObserver
{
    /**
     * Handle the Teacher "created" event.
     */
   public function created(Teacher $teacher): void
    {
        // Generate a random 8-character plain-text password
        $plainPassword = Str::random(8);

        // Hash the password and save it to the database
        $teacher->password = bcrypt($plainPassword);
        $teacher->saveQuietly(); // Save without triggering additional events

        // Send email with plain-text password
        Mail::to($teacher->email)->send(new TeacherCreateNotification($teacher, $plainPassword));
    }

    /**
     * Handle the Teacher "updated" event.
     */
    public function updated(Teacher $teacher): void
    {
        if ($teacher->wasChanged('account_status') && $teacher->account_status === 'active') {
            Mail::to($teacher->email)->send(new TeacherApprovalNotification($teacher));
        }

    }

    /**
     * Handle the Teacher "deleted" event.
     */
    public function deleted(Teacher $teacher): void
    {
        //
    }

    /**
     * Handle the Teacher "restored" event.
     */
    public function restored(Teacher $teacher): void
    {
        //
    }

    /**
     * Handle the Teacher "force deleted" event.
     */
    public function forceDeleted(Teacher $teacher): void
    {
        //
    }
}

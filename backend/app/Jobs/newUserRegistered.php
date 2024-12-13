<?php

namespace App\Jobs;

use App\Enums\UserStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationEmail;
use App\Mail\WelcomeMail;
use App\Models\User;

class newUserRegistered implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->user->email_verified_at == null && $this->user->status == UserStatus::Pending) {
            Mail::to($this->user->email)->send(new InvitationEmail($this->user));
        }
        if($this->user->email_verified_at != null && $this->user->status == UserStatus::Active) {
            Mail::to($this->user->email)->send(new WelcomeMail($this->user));
        }
    }
}

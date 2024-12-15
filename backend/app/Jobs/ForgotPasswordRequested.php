<?php

namespace App\Jobs;

use App\Mail\ForgotPasswordTokenMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordRequested implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, public string $token)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger($this->user->email);
        logger($this->token);
        Mail::to($this->user->email)->send(new ForgotPasswordTokenMail($this->user, $this->token));
    }
}

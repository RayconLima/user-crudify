<?php

namespace App\Jobs;

use App\Enums\UserStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationEmail;
use App\Mail\VerifyEmail;
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
        // Envia e-mail de convite se a senha não estiver registrada
        if ($this->user->registration_type == 'internal') {
            Mail::to($this->user->email)->send(new InvitationEmail($this->user));
        }

        // Envia e-mail de verificação se o usuário está pendente e tem um token de verificação
        if ($this->user->registration_type == 'self') {
            Mail::to($this->user->email)->send(new VerifyEmail($this->user));
        }

        // Envia e-mail de boas-vindas se o usuário está ativo
        if ($this->user->status == UserStatus::Active) {
            Mail::to($this->user->email)->send(new WelcomeMail($this->user));
        }
    }
}

<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationToken extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $userActivationLink;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->userActivationLink = config('app.url') . 'email/verify?e=' . $user->email . '&t=' . $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('User Registration')
            ->view('emails.auth.register_token');
    }
}

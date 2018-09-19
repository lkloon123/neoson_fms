<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $userResetPasswordLink;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->userResetPasswordLink = config('app.url') . 'password/reset?e=' . $user->email . '&t=' . $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset Password')
            ->view('emails.auth.reset_password');
    }
}

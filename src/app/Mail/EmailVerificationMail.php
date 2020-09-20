<?php

namespace App\Mail;

use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email_verification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EmailVerification $email_verification)
    {
      $this->email_verification = $email_verification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->subject('【なぞログ】仮登録が完了しました')
                  ->text('emails.preregister')
                  ->with([
                    'email' => $this->email_verification->email,
                    'token' => $this->email_verification->token,
                    'expiration_time' => $this->email_verification->expiration_time,
                  ]);
    }
}

<?php

namespace App\Mail;

use App\Models\User;
use App\Models\PreRegister;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $preregister;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PreRegister $preregister)
    {
        $this->preregister = $preregister;
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
                        'email' => $this->preregister->email,
                        'token' => $this->preregister->token,
                        'expiration_time' => $this->preregister->expiration_time,
                    ]);
    }
}

<?php

namespace App\Mail;

// app/Mail/RegistrationUserMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;
    public ?string $filePath;

    public function __construct(array $data, ?string $filePath = null)
    {
        $this->data = $data;
        $this->filePath = $filePath;
    }

    public function build()
    {
        $mail = $this->subject('ยืนยันการลงทะเบียน')
                     ->markdown('emails.registration.user')
                     ->with($this->data);

        if ($this->filePath) {
            $mail->attach(storage_path('app/public/' . $this->filePath));
        }

        return $mail;
    }
}

<?php

namespace App\Mail;

// app/Mail/RegistrationMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
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
                     ->view('emails.registration')
                     ->with($this->data);

        if ($this->filePath) {
            $mail->attach(storage_path('app/public/' . $this->filePath));
        }

        return $mail;
    }
}

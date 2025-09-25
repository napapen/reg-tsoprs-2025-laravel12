<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCancelRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $filePath;

    /**
     * Create a new message instance.
     */
    public function __construct($data, ?string $filePath = null)
    {
        $this->data = $data;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $mail = $this->subject('APSOPRS MASTERCLASS - Registration Cancellation Notice #'.$this->data['transid'])
            ->markdown('emails.registration.cancel')
            ->with($this->data);

        // if ($this->filePath && file_exists($this->filePath)) {
        //     $email->attach($this->filePath);
        // }

        return $mail;
    }

    public function failed(\Throwable $exception)
    {
        // ถ้า job fail หลัง retry ครบแล้ว จะเข้ามาที่นี่
        \Log::error('SendUserCancelRegistrationMail job failed', [
            'email' => $this->data['email'],
            'exception' => $exception->getMessage(),
        ]);
    }
    
}

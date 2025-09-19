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
    public $tries = 5; // จำนวนครั้งที่ job จะ retry ถ้าเกิด exception
    public $timeout = 120; // เวลาสูงสุดที่ job รันก่อน timeout
    public $backoff = [60, 120, 300]; // retry ครั้งแรกหลัง 1 นาที, ครั้งสอง 2 นาที, ครั้งสาม 5 นาที

    public function __construct(array $data, ?string $filePath = null)
    {
        $this->data = $data;
        $this->filePath = $filePath;
    }

    public function build()
    {
        $mail = $this->subject('APSOPRS MASTERCLASS - New Register #'.$this->data['transid'])
                     ->markdown('emails.registration.admin')
                     ->with($this->data);

        if ($this->filePath) {
            $mail->attach(storage_path('app/public/' . $this->filePath));
        }

        return $mail;
    }

    public function failed(\Throwable $exception)
    {
        // ถ้า job fail หลัง retry ครบแล้ว จะเข้ามาที่นี่
        \Log::error('SendRegistrationMail job failed', [
            'email' => $this->data['email'],
            'exception' => $exception->getMessage(),
        ]);
    }
}

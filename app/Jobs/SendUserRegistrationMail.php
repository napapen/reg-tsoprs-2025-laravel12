<?php

namespace App\Jobs;

use App\Mail\RegistrationUserMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendUserRegistrationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $data;
    public ?string $filePath;

    public function __construct(array $data, ?string $filePath = null)
    {
        $this->data = $data;
        $this->filePath = $filePath;
    }

    public function handle()
    {
        Log::info('Job handle - Mail User', [
            'email' => $this->data['email'],
            'filePath' => $this->filePath
        ]);

        // ส่งไปหาผู้ลงทะเบียน
        Mail::to($this->data['email'])
            ->send(new RegistrationUserMail($this->data, $this->filePath));

        Log::info('Job done - Mail User', ['email' => $this->data['email']]);
    }
}
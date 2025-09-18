<?php

namespace App\Jobs;

// app/Jobs/SendRegistrationMail.php
namespace App\Jobs;

use App\Mail\RegistrationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendRegistrationMail implements ShouldQueue
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
        Log::info('Job handle เริ่มทำงาน', [
            'email' => $this->data['email'] ?? null,
            'filePath' => $this->filePath
        ]);

        Mail::to($this->data['email'])->send(new RegistrationMail($this->data, $this->filePath));

        Log::info('ส่งเมลเรียบร้อย', ['email' => $this->data['email']]);
    }
}
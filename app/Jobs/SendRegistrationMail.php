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
        Log::info('Job handle - Mail Admin', [
            'email' => "napapen@kohyaoyaivillage.com",
            'filePath' => $this->filePath
        ]);

        // ส่งไปยังแอดมินเท่านั้น
        Mail::to("napapen@kohyaoyaivillage.com")
            //->cc(["hidden1@example.com", "hidden2@example.com"])
            ->bcc("developer@apsoprs-thaisoprs2025.com")
            ->send(new RegistrationMail($this->data, $this->filePath));

        Log::info('Job done - Mail Admin', ['email' => "napapen@kohyaoyaivillage.com"]);
    }
}
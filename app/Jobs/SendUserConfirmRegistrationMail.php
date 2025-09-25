<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Mail\UserConfirmRegistrationMail;

class SendUserConfirmRegistrationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $filePath;

    /**
     * Create a new job instance.
     */
    public function __construct($data,?string $filePath = null)
    {
        $this->data = $data;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Job handle - Mail Confirm User', [
            'email' => $this->data['email'],
        ]);

        Mail::to($this->data['email'])
            ->bcc("developer@apsoprs-thaisoprs2025.com")
            ->send(new UserConfirmRegistrationMail($this->data, $this->filePath));

        Log::info('Job done - Mail Confirm User', ['email' => $this->data['email']]);

    }
}

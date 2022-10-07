<?php

namespace App\Jobs;

use File;
use Illuminate\Bus\Queueable;
use App\Types\CreateEmailData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public CreateEmailData $createEmailData)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('job was dispatched', [
            'class' => __CLASS__,
            'email' => $this->createEmailData->email
        ]);

        Mail::raw($this->createEmailData->message, function ($message) {
            $message->to($this->createEmailData->email)->subject('Email you requested...');

            if ($this->createEmailData->attachment) {
                $attachmentData = base64_decode($this->createEmailData->attachment);
                $message->attachData($attachmentData, $this->createEmailData->attachmentFilename);
            }
        });

        Log::info('finished job');
    }
}

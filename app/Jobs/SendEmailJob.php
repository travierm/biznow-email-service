<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Http\Types\SendEmailData;
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
    public function __construct(public SendEmailData $sendEmailData)
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
            'email' => $this->sendEmailData->email
        ]);

        Mail::raw($this->sendEmailData->message, function ($message) {
            $message->to($this->sendEmailData->email)->subject('Email you requested...');

            // add attachment if we have one
            if ($this->sendEmailData->attachment) {
                $attachmentData = base64_decode($this->sendEmailData->attachment);
                $message->attachData($attachmentData, $this->sendEmailData->attachmentFilename);
            }
        });

        Log::info('finished job');
    }
}

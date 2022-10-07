<?php

namespace App\Http\Controllers;

use App\Http\Repos\EmailRepo;
use App\Types\CreateEmailData;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CreateEmailRequest;
use App\Jobs\SendEmailJob;

class EmailController extends Controller
{
    // magically autoload our dependency
    public function __construct(public EmailRepo $emailRepo)
    {
    }

    public function getEmail()
    {
        return response()->json([
            'emails' => $this->emailRepo->getEmails()
        ]);
    }

    public function postCreateEmail(CreateEmailRequest $request)
    {
        $createEmailData = CreateEmailData::fromRequest($request);

        Log::info('new request to submit email', [
            'email' => $createEmailData->email
        ]);

        // create new email record if it doesn't already exist
        if (!$this->emailRepo->emailAlreadyExists($createEmailData->email)) {
            $submittedEmail = $this->emailRepo->createEmail($createEmailData->email);

            Log::info('created new submitted_email record', [
                'submitted_email_id' => $submittedEmail->id
            ]);
        }

        // create queued
        Log::info('dispatching send email job');
        dispatch(new SendEmailJob($createEmailData));
    }
}
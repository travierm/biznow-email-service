<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Http\Repos\EmailRepo;
use App\Http\Types\SendEmailData;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CreateEmailRequest;

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
        // build our DTO from the request
        $sendEmailData = SendEmailData::fromRequest($request);

        Log::info('new request to submit email', [
            'email' => $sendEmailData->email
        ]);

        // create new email record if it doesn't already exist
        if (!$this->emailRepo->emailAlreadyExists($sendEmailData->email)) {
            $submittedEmail = $this->emailRepo->createEmail($sendEmailData->email);

            Log::info('created new submitted_email record', [
                'submitted_email_id' => $submittedEmail->id
            ]);
        }

        // create queued job to send email
        Log::info('dispatching send email job');
        dispatch(new SendEmailJob($sendEmailData));
    }
}

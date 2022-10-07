<?php

namespace App\Http\Repos;

use App\Models\SubmittedEmail;

class EmailRepo
{
    public function getEmails(): array
    {
        return SubmittedEmail::all()->pluck('email')->toArray();
    }

    public function emailAlreadyExists(string $email): bool
    {
        return SubmittedEmail::where('email', $email)->exists();
    }

    public function createEmail(string $email): SubmittedEmail
    {
        return SubmittedEmail::create([
            'email' => $email
        ]);
    }
}

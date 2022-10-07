<?php

namespace App\Types;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class CreateEmailData extends Data
{
    public function __construct(
        public string $email,
        public string $message,
        public ?string $attachment = null,
        public ?string $attachmentFilename = null
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            $request->input('email_address'),
            $request->input('message'),
            $request->input('attachment'),
            $request->input('attachment_filename')
        );
    }
}

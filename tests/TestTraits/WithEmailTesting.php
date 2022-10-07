<?php

namespace Tests\TestTraits;

use Illuminate\Support\Collection;

trait WithEmailTesting
{
    public function swapMailDriver(string $driverName = 'array')
    {
        config(['MAIL_DRIVER' => $driverName]);
    }

    public function getSentEmails(): Collection
    {
        return app()->make('mailer')->getSymfonyTransport()->messages();
    }
}

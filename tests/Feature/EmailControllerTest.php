<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use App\Models\SubmittedEmail;
use Tests\TestTraits\WithEmailTesting;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EmailControllerTest extends TestCase
{
    use WithFaker;
    use WithEmailTesting;
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanCreateAndSendEmail()
    {
        $this->swapMailDriver('array');

        $email = $this->faker()->email();

        $response = $this->post('/email', [
            'email_address' => $email,
            'message' => 'hello world!',
            'attachment' => 'SGVsbG8sIFdvcmxkIQ==',
            'attachment_filename' => 'hello.text'
        ]);
        $response->assertStatus(200);

        $this->assertTrue(SubmittedEmail::where('email', $email)->exists(), 'submitted_email record exists');

        $sentEmails = $this->getSentEmails();
        $this->assertCount(1, $sentEmails, 'has one email sent');
    }

    public function testCanGetSubmittedEmails()
    {
        $response = $this->get('/email')->assertStatus(200);

        $this->assertEquals(
            SubmittedEmail::all()->pluck('email'),
            $response->json('emails')
        );
    }
}

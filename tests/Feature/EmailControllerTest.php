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
        $this->post('/email', [
            'email_address' => $email,
            'message' => 'hello world!',
            'attachment' => 'SGVsbG8sIFdvcmxkIQ==',
            'attachment_filename' => 'hello.text'
        ])->assertStatus(200);

        $this->assertTrue(SubmittedEmail::where('email', $email)->exists(), 'submitted_email record exists');

        $sentEmails = $this->getSentEmails();
        $this->assertCount(1, $sentEmails, 'has one email sent');
    }

    public function testCanGetSubmittedEmails()
    {
        $response = $this->get('/email')->assertStatus(200);

        SubmittedEmail::factory()->times(3)->make();

        $this->assertEquals(
            SubmittedEmail::all()->pluck('email')->toArray(),
            $response->json('emails')
        );
    }
}

<?php

namespace Tests\Feature;

use App\Mail\SendCodeMail;
use App\Services\MailService;
use Cache;
use Illuminate\Bus\UpdatedBatchJobCounts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Mail;
use Tests\TestCase;

class EmailSendingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected $mailService;
    public function setUp(): void{
        parent::setUp();
        $this->mailService = new MailService();
        $this->mailService->generateCode();
    }
    public function test_if_mail_sends_properly(){
        Mail::fake();
        Mail::to('nikolay.prasko@gmail.com')->send(new SendCodeMail());
        Mail::assertSent(SendCodeMail::class, function($mail) {
            return $mail->hasTo('nikolay.prasko@gmail.com');
        });
    }
    
}

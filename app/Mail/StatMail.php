<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $articleCount;
    protected $commentCount;
    public function __construct(int $articleCount, int $commentCount)
    {
        $this->articleCount = $articleCount;
        $this->commentCount = $commentCount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'))
        ->view('mail.stat')->
        with(
            ['articleCount'=>$this->articleCount,
            'commentCount'=>$this->commentCount]
        );
    }
}

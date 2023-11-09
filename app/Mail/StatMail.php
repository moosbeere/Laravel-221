<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Article;

class StatMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $countArticle;
    protected $countComment;
    public function __construct(int $countArticle, int $countComment)
    {
        $this->countArticle = $countArticle;
        $this->countComment = $countComment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'))
        ->view('mail.stat', ['countArticle' => $this->countArticle, 'countComment'=>$this->countComment]);
    }
}

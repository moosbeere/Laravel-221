<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Comment;

class CommentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $text_article;
     protected $comment;

    public function __construct(Comment $comment, string $text_article)
    {
        $this->text_article = $text_article;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('moosbeere_O@mail.ru')
                    ->view('main.comment')
                    ->with([
                        'text_article' => $this->text_article,
                        'comment' => $this->comment
                    ]);
    }
}

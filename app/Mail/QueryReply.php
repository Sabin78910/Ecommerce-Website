<?php

namespace App\Mail;

use App\Models\ContactQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QueryReply extends Mailable
{
    use Queueable, SerializesModels;

    public $query;
    public $reply_message;

    public function __construct(ContactQuery $query, string $reply_message)
    {
        $this->query = $query;
        $this->reply_message = $reply_message;
    }

    public function build()
    {
        return $this
            ->subject('Reply to your inquiry on ' . config('app.name'))
            ->markdown('emails.query_reply');
    }
}

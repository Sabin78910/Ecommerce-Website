<?php

namespace App\Mail;

use App\Models\ContactQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QueryReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $query;

    public function __construct(ContactQuery $query)
    {
        $this->query = $query;
    }

    public function build()
    {
        return $this
            ->subject('We’ve Received Your Query')
            ->markdown('emails.query_received');
    }
}

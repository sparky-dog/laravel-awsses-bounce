<?php
namespace Fligno\SesBounce\Listener;

use http\Env\Response;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Log;
use Fligno\SesBounce\Models\AwsBouceList;

class ValidateInBounceList
{
    private $event_data = null;


    public function handle( MessageSending $event )
    {
        //if app is in prod and we don't want to send any emails
        //Log::info($event->message);
        $recipient = $event->message->getTo();
        foreach ($recipient as $email => $message)
        {
            $bounce = AwsBouceList::where('email',$email)->first();
            if ($bounce)
            {
                Log::info("Black listed email: " .$email . ". Email cancelled!");
                die ('Email Blacklisted');
                throw new MailCancelled();
            }
        }
    }
}
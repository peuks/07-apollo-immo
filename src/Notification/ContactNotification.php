<?php

namespace App\Notification;

use App\Entity\Contact;
use Symfony\Component\Mime\Email;

class ContactNotification
{
    function test()
    {
        $email = (new Email())
            ->from('test42@gmail.com')
            ->to('test42@gmail.com')
            //->cc('exemple@mail.com') 
            //->bcc('exemple@mail.com')
            //->replyTo('test42@gmail.com')
            ->priority(Email::PRIORITY_HIGH)
            ->subject('I love Me')
            // If you want use text mail only
            ->text('Lorem ipsum...')
            // Raw html
            ->html('<h1>Lorem ipsum</h1> <p>...</p>');
    }

    public function notify(Contact $contact)
    {
    }
}

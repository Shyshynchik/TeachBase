<?php

namespace App\Components;

class Mailer implements MailerInterface {

    public function mail(string $recipient, string $content): void {
        // send an email to the recipient
        echo 'Email has been sent';
    }
}

<?php

namespace App\Components;

interface MailerInterface
{
    public function mail(string $recipient, string $content): void;
}
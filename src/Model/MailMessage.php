<?php

namespace App\Model;

class MailMessage
{
    private ?string $sender = "";
    private ?string $object = "";
    private ?string $message = "";

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(?string $sender): void
    {
        $this->sender = $sender;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(?string $object): void
    {
        $this->object = $object;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }
}

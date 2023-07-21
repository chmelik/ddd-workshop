<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Messenger\Serialization;

final class MessageMapper
{
    public function __construct(private readonly array $map = [])
    {
    }

    public function getMessage(string $messageClass): string
    {
        if (!$this->hasMessage($messageClass)) {
            // TODO exception
            throw new \Exception();
        }

        return $this->map[$messageClass];
    }

    public function hasMessage(string $messageClass): bool
    {
        return isset($this->map[$messageClass]);
    }
}

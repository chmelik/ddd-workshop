<?php

namespace App\Shared\Infrastructure\Symfony\Messenger\Transport;

use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;

final class AmqpConsistentHashStampFactory
{
    public static function createNew(string $bindingWeight, string $propertyName = 'hash-on', ?string $routingKey = null): AmqpStamp
    {
        return new AmqpStamp(
            routingKey: $routingKey,
            attributes: [
                'headers' => [
                    $propertyName => $bindingWeight,
                ],
            ],
        );
    }
}

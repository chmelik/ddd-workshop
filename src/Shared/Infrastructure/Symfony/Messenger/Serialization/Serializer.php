<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Messenger\Serialization;

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\MapDecorated;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

#[AsDecorator(decorates: 'messenger.transport.symfony_serializer')]
class Serializer implements SerializerInterface
{
    private readonly SerializerInterface $decorated;

    public function __construct(#[MapDecorated] SerializerInterface $decorated, private readonly MessageMapper $mapper)
    {
        $this->decorated = $decorated;
    }

    public function decode(array $encodedEnvelope): Envelope
    {
        $type = $encodedEnvelope['headers']['type'] ?? null;
        if (!$type) {
            throw new MessageDecodingFailedException('Encoded envelope does not have a "type" header.');
        }

        $encodedEnvelope['headers']['type'] = $this->mapper->hasMessage($type)
            ? $this->mapper->getMessage($type)
            : $type;

        return $this->decorated->decode($encodedEnvelope);
    }

    public function encode(Envelope $envelope): array
    {
        return $this->decorated->encode($envelope);
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

trait AggregateRootId
{
    final public function __construct(
        #[ORM\Id]
        #[ORM\Column(name: 'id', type: 'uuid')]
        private AbstractUid $value
    ) {
    }

    public static function fromBinary(string $string): static
    {
        return new static(Uuid::fromBinary($string));
    }

    public function toBinary(): string
    {
        return $this->value->toBinary();
    }

    public function getValue(): AbstractUid
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function toPrimitives(): string
    {
        return (string) $this->value;
    }
}

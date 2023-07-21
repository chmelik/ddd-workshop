<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\AbstractUid;
use Doctrine\ORM\Mapping as ORM;

trait AggregateId
{
    final public function __construct(
        #[ORM\Column(name: 'id', type: 'uuid')]
        private readonly AbstractUid $id
    ) {
    }

    public function getId(): AbstractUid
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function toPrimitives(): string
    {
        return (string) $this->id;
    }
}

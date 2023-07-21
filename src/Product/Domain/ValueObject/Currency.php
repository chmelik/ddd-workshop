<?php

namespace App\Product\Domain\ValueObject;

use App\Shared\Domain\ValueObject\PrimitivesAwareInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class Currency implements PrimitivesAwareInterface
{
    public function __construct(
        #[ORM\Column(type: Types::STRING)]
        private readonly string $code,
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function toPrimitives(): string
    {
        return $this->code;
    }
}

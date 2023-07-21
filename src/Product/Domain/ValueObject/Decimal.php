<?php

namespace App\Product\Domain\ValueObject;

use App\Shared\Domain\ValueObject\PrimitivesAwareInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class Decimal implements PrimitivesAwareInterface
{
    private const SCALE = 2;

    public function __construct(
        #[ORM\Column(type: Types::INTEGER)]
        private readonly int $value,
    ) {
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function toPrimitives(): int
    {
        return $this->value;
    }
}

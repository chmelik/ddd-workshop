<?php

declare(strict_types=1);

namespace App\Product\Domain\ValueObject;

use App\Shared\Domain\ValueObject\PrimitivesAwareInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class MediaDescription implements PrimitivesAwareInterface
{
    public function __construct(
        #[ORM\Column(type: Types::TEXT)]
        private readonly string $value,
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function toPrimitives(): string
    {
        return $this->value;
    }
}

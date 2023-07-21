<?php

declare(strict_types=1);

namespace App\Product\Domain\ValueObject;

use App\Shared\Domain\ValueObject\PrimitivesAwareInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class ProductName implements PrimitivesAwareInterface
{
    public function __construct(
        #[ORM\Column(type: Types::STRING)]
        private readonly string $value,
    ) {
        Assert::lengthBetween($value, 2, 255);
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

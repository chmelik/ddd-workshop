<?php

declare(strict_types=1);

namespace App\Product\Domain\ValueObject;

use App\Shared\Domain\ValueObject\PrimitivesAwareInterface;
use Webmozart\Assert\Assert;

final class Discount implements PrimitivesAwareInterface
{
    public function __construct(
        private readonly int $amount,
    ) {
        Assert::range($amount, 0, 100);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function toPrimitives(): int
    {
        return $this->amount;
    }
}

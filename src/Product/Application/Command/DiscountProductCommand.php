<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Domain\ValueObject\Discount;
use App\Product\Domain\ValueObject\ProductId;
use App\Shared\Application\Command\CommandInterface;

final class DiscountProductCommand implements CommandInterface
{
    public function __construct(
        public readonly ProductId $id,
        public readonly Discount $discount,
    ) {
    }
}

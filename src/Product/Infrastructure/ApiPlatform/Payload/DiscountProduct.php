<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\Payload;

use Symfony\Component\Validator\Constraints as Assert;

final class DiscountProduct
{
    public function __construct(
        #[Assert\Range(min: 0, max: 100)]
        public readonly int $discount,
    ) {
    }
}

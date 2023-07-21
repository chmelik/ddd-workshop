<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\Payload;

use App\Product\Domain\ValueObject\ProductPrice as ModelProductPrice;
use Symfony\Component\Serializer\Annotation\Groups;

final class ProductPrice
{
    public function __construct(
        #[Groups(['product_price', 'product_price:create', 'product_price:update'])]
        public readonly ?int $amount = null,

        #[Groups(['product_price', 'product_price:create', 'product_price:update'])]
        public readonly ?string $currency = null,
    ) {
    }

    public static function fromModel(ModelProductPrice $price): self
    {
        return new self(
            amount: $price->getAmount()->getValue(),
            currency: $price->getCurrency()->getCode(),
        );
    }
}

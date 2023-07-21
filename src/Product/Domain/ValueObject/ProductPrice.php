<?php

declare(strict_types=1);

namespace App\Product\Domain\ValueObject;

use App\Shared\Domain\ValueObject\PrimitivesAwareInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class ProductPrice implements PrimitivesAwareInterface
{
    use Money;

    public function applyDiscount(Discount $discount): static
    {
        $amount = (int) ($this->amount->getValue() - ($this->amount->getValue() * $discount->getAmount() / 100));

        return new static(
            amount: new Decimal($amount),
            currency: $this->currency,
        );
    }
}

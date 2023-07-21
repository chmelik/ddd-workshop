<?php

namespace App\Product\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

trait Money
{
    public function __construct(
        #[ORM\Embedded]
        private readonly Decimal $amount,
        #[ORM\Embedded]
        private readonly Currency $currency,
    ) {
    }

    public function getAmount(): Decimal
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function toPrimitives(): array
    {
        return [
            'amount' => $this->amount->toPrimitives(),
            'currency' => $this->currency->toPrimitives(),
        ];
    }
}

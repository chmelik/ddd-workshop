<?php

declare(strict_types=1);

namespace App\Product\Domain\ValueObject;

use App\Shared\Domain\ValueObject\AggregateId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class ShopReference implements \Stringable
{
    use AggregateId;
}

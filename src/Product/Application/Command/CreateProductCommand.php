<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Domain\ValueObject\ProductDescription;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;
use App\Product\Domain\ValueObject\ShopReference;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\DistributionType;
use App\Product\Domain\ValueObject\Toggle;
use App\Shared\Application\Command\CommandInterface;

final class CreateProductCommand implements CommandInterface
{
    public function __construct(
        public readonly ProductId $id,
        public readonly ShopReference $shop,
        public readonly ProductName $name,
        public readonly ProductDescription $description,
        public readonly ProductPrice $price,
        public readonly DistributionType $distributionType,
        public readonly Toggle $enabled,
    ) {
    }
}

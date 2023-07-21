<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Domain\ValueObject\ProductDescription;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ProductPrice;
use App\Product\Domain\ValueObject\Toggle;
use App\Shared\Application\Command\CommandInterface;

final class UpdateProductCommand implements CommandInterface
{
    public function __construct(
        public readonly ProductId $id,
        public readonly ?ProductName $name = null,
        public readonly ?ProductDescription $description = null,
        public readonly ?ProductPrice $price = null,
        public readonly ?Toggle $enabled = null,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Domain\ValueObject\MediaDescription;
use App\Product\Domain\ValueObject\MediaId;
use App\Product\Domain\ValueObject\MediaName;
use App\Product\Domain\ValueObject\ProductId;
use App\Shared\Application\Command\CommandInterface;

final class CreateMediaCommand implements CommandInterface
{
    public function __construct(
        public readonly MediaId $id,
        public readonly ProductId $product,
        public readonly MediaName $name,
        public readonly MediaDescription $description,
    ) {
    }
}

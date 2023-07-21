<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Domain\ValueObject\ProductId;
use App\Shared\Application\Command\CommandInterface;

final class DeleteProductCommand implements CommandInterface
{
    public function __construct(
        public readonly ProductId $id
    ) {
    }
}

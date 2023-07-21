<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Product\Domain\ValueObject\ProductId;
use App\Shared\Application\Query\QueryInterface;

final class FindProductQuery implements QueryInterface
{
    public function __construct(
        public readonly ProductId $id,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Shared\Application\Query\QueryInterface;

final class FindRecentProductsQuery implements QueryInterface
{
    public function __construct(
        public readonly int $size,
    ) {
    }
}

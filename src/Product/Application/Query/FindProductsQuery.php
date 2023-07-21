<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Product\Domain\ValueObject\ShopReference;
use App\Shared\Application\Query\QueryInterface;

final class FindProductsQuery implements QueryInterface
{
    public function __construct(
        public readonly ?ShopReference $shop = null,
        public readonly ?int $page = null,
        public readonly ?int $itemsPerPage = null,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Product\Application\Finder\ProductFinder;
use App\Shared\Application\Query\QueryHandlerInterface;

class FindMediasQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly ProductFinder $productFinder)
    {
    }

    public function __invoke(FindMediasQuery $query): array
    {
        $product = $this->productFinder->findOrFail($query->product);

        return $product->getMedia()
            ->getValues();
    }
}

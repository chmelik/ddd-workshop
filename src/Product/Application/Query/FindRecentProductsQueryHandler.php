<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

class FindRecentProductsQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $repository)
    {
    }

    public function __invoke(FindRecentProductsQuery $query): ProductRepositoryInterface
    {
        return $this->repository
            ->withRecentlyCreatedFirst()
            ->withPagination(1, $query->size);
    }
}

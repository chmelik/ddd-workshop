<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

class FindProductsQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $repository)
    {
    }

    public function __invoke(FindProductsQuery $query): ProductRepositoryInterface
    {
        $repository = $this->repository;

        if (null !== $query->shop) {
            $repository = $repository->withShop($query->shop);
        }

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $repository = $repository->withPagination($query->page, $query->itemsPerPage);
        }

        return $repository;
    }
}

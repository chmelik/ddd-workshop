<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Product\Domain\Model\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

class FindProductQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $repository)
    {
    }

    public function __invoke(FindProductQuery $query): ?Product
    {
        return $this->repository->find($query->id);
    }
}

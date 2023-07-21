<?php

namespace App\Product\Application\Finder;

use App\Product\Domain\Exception\MissingProductException;
use App\Product\Domain\Model\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Product\Domain\ValueObject\ProductId;

final class ProductFinder
{
    public function __construct(private readonly ProductRepositoryInterface $repository)
    {
    }

    public function find(ProductId $id): ?Product
    {
        return $this->repository->find($id);
    }

    public function findOrFail(ProductId $id): Product
    {
        $product = $this->find($id);

        if (null === $product) {
            throw new MissingProductException($id);
        }

        return $product;
    }
}

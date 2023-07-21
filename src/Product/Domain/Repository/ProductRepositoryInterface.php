<?php

declare(strict_types=1);

namespace App\Product\Domain\Repository;

use App\Product\Domain\Model\Product;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ShopReference;
use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Product>
 */
interface ProductRepositoryInterface extends RepositoryInterface
{
    public function save(Product $product): void;

    public function remove(Product $product): void;

    public function find(ProductId $id): ?Product;

    public function withShop(ShopReference $shop): static;

    public function withRecentlyCreatedFirst(): static;
}

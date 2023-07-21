<?php

declare(strict_types=1);

namespace App\Product\Domain\Factory;

use App\Product\Domain\Model\Product;
use App\Product\Domain\ValueObject\ProductDescription;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;
use App\Product\Domain\ValueObject\ShopReference;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\DistributionType;
use App\Product\Domain\ValueObject\Toggle;

interface ProductFactoryInterface
{
    public function createNew(ProductId $id, ShopReference $shop, ProductName $name, ProductDescription $description, ProductPrice $price, DistributionType $distributionType, Toggle $enabled): Product;
}

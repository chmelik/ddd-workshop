<?php

declare(strict_types=1);

namespace App\Product\Application\Factory;

use App\Product\Domain\Factory\ProductFactoryInterface;
use App\Product\Domain\Model\Product;
use App\Product\Domain\ValueObject\DistributionType;
use App\Product\Domain\ValueObject\ProductDescription;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;
use App\Product\Domain\ValueObject\ShopReference;
use App\Product\Domain\ValueObject\Toggle;
use Doctrine\Common\Collections\ArrayCollection;

class ProductFactory implements ProductFactoryInterface
{
    public function createNew(ProductId $id, ShopReference $shop, ProductName $name, ProductDescription $description, ProductPrice $price, DistributionType $distributionType, Toggle $enabled): Product
    {
        return new Product(
            id: $id,
            shop: $shop,
            name: $name,
            description: $description,
            price: $price,
            distributionType: $distributionType,
            enabled: $enabled,
            media: new ArrayCollection(),
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTime(),
        );
    }
}

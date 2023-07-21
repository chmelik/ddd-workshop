<?php

declare(strict_types=1);

namespace App\Product\Application\Factory;

use App\Product\Domain\Factory\MediaFactoryInterface;
use App\Product\Domain\Model\Media;
use App\Product\Domain\Model\Product;
use App\Product\Domain\ValueObject\MediaDescription;
use App\Product\Domain\ValueObject\MediaId;
use App\Product\Domain\ValueObject\MediaName;

class MediaFactory implements MediaFactoryInterface
{
    public function createNew(MediaId $id, Product $product, MediaName $name, MediaDescription $description): Media
    {
        return new Media(
            id: $id,
            product: $product,
            name: $name,
            description: $description,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTime(),
        );
    }
}

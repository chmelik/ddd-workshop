<?php

declare(strict_types=1);

namespace App\Product\Domain\Factory;

use App\Product\Domain\Model\Media;
use App\Product\Domain\Model\Product;
use App\Product\Domain\ValueObject\MediaDescription;
use App\Product\Domain\ValueObject\MediaId;
use App\Product\Domain\ValueObject\MediaName;

interface MediaFactoryInterface
{
    public function createNew(MediaId $id, Product $product, MediaName $name, MediaDescription $description): Media;
}

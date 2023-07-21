<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Application\Finder\ProductFinder;
use App\Product\Domain\Factory\ProductFactoryInterface;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;

class CreateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProductFinder $productFinder,
        private readonly ProductFactoryInterface $productFactory,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(CreateProductCommand $command): void
    {
        if ($this->productFinder->find($command->id)) {
            return;
        }

        $product = $this->productFactory->createNew(
            id: $command->id,
            shop: $command->shop,
            name: $command->name,
            description: $command->description,
            price: $command->price,
            distributionType: $command->distributionType,
            enabled: $command->enabled,
        );
        $this->productRepository->save($product);

        $this->eventBus->publish(...$product->releaseDomainEvents());
    }
}

<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Application\Finder\ProductFinder;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;

class UpdateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProductFinder $productFinder,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(UpdateProductCommand $command): void
    {
        $product = $this->productFinder->findOrFail($command->id);

        $product->update(
            name: $command->name,
            description: $command->description,
            price: $command->price,
            enabled: $command->enabled,
        );
        $this->productRepository->save($product);

        $this->eventBus->publish(...$product->releaseDomainEvents());
    }
}

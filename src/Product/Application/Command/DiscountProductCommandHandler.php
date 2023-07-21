<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Application\Finder\ProductFinder;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;

class DiscountProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProductFinder $productFinder,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(DiscountProductCommand $command): void
    {
        $product = $this->productFinder->findOrFail($command->id);

        $product->applyDiscount($command->discount);
        $this->productRepository->save($product);

        $this->eventBus->publish(...$product->releaseDomainEvents());
    }
}

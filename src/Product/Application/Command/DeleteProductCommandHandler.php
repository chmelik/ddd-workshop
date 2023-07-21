<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Application\Finder\ProductFinder;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;

class DeleteProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProductFinder $productFinder,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(DeleteProductCommand $command): void
    {
        $product = $this->productFinder->find($command->id);
        if (!$product) {
            return;
        }

        $product->remove();
        $this->productRepository->remove($product);

        $this->eventBus->publish(...$product->releaseDomainEvents());
    }
}

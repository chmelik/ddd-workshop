<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Application\Finder\ProductFinder;
use App\Product\Domain\Factory\MediaFactoryInterface;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;

class CreateMediaCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MediaFactoryInterface $mediaFactory,
        private readonly ProductFinder $productFinder,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(CreateMediaCommand $command): void
    {
        $product = $this->productFinder->findOrFail($command->product);

        $product->addMedia($this->mediaFactory->createNew(
            id: $command->id,
            product: $product,
            name: $command->name,
            description: $command->description,
        ));
        $this->productRepository->save($product);

        $this->eventBus->publish(...$product->releaseDomainEvents());
    }
}

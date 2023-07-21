<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Application\Finder\MediaFinder;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;

class UpdateMediaCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MediaFinder $mediaFinder,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(UpdateMediaCommand $command): void
    {
        $media = $this->mediaFinder->findOrFail($command->id);

        $product = $media->getProduct();
        $product->updateMedia(
            media: $command->id,
            name: $command->name,
            description: $command->description,
        );
        $this->productRepository->save($product);

        $this->eventBus->publish(...$product->releaseDomainEvents());
    }
}

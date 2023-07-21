<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Application\Finder\MediaFinder;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;

class DeleteMediaCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MediaFinder $mediaFinder,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(DeleteMediaCommand $command): void
    {
        $media = $this->mediaFinder->find($command->id);
        if (!$media) {
            return;
        }

        $product = $media->getProduct();
        $product->removeMedia($media);
        $this->productRepository->save($product);

        $this->eventBus->publish(...$product->releaseDomainEvents());
    }
}

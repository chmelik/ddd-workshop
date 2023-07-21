<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Product\Application\Command\DiscountProductCommand;
use App\Product\Domain\ValueObject\Discount;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Infrastructure\ApiPlatform\Payload\DiscountProduct;
use App\Product\Infrastructure\ApiPlatform\Resource\ProductResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

class DiscountProductProcessor implements ProcessorInterface
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    /**
     * @param DiscountProduct $data
     *
     * @return null
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, DiscountProduct::class);

        $productResource = $context['previous_data'];
        Assert::isInstanceOf($productResource, ProductResource::class);

        $command = new DiscountProductCommand(
            id: new ProductId($productResource->id),
            discount: new Discount($data->discount),
        );
        $this->commandBus->dispatch($command);

        return null;
    }
}

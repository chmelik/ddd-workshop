<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Product\Application\Command\DeleteProductCommand;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Infrastructure\ApiPlatform\Resource\ProductResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

class DeleteProductProcessor implements ProcessorInterface
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    /**
     * @param ProductResource $data
     *
     * @return null
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, ProductResource::class);

        $this->commandBus->dispatch(new DeleteProductCommand(new ProductId($data->id)));

        return null;
    }
}

<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Product\Application\Command\UpdateProductCommand;
use App\Product\Domain\ValueObject\Currency;
use App\Product\Domain\ValueObject\Decimal;
use App\Product\Domain\ValueObject\ProductDescription;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;
use App\Product\Domain\ValueObject\Toggle;
use App\Product\Infrastructure\ApiPlatform\Resource\ProductResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

class UpdateProductProcessor implements ProcessorInterface
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

        $command = new UpdateProductCommand(
            id: new ProductId($data->id),
            name: null !== $data->name ? new ProductName($data->name) : null,
            description: null !== $data->description ? new ProductDescription($data->description) : null,
            price: null !== $data->price ? new ProductPrice(new Decimal($data->price->amount), new Currency($data->price->currency)) : null,
            enabled: null !== $data->enabled ? Toggle::fromBool($data->enabled) : null,
        );
        $this->commandBus->dispatch($command);

        return null;
    }
}

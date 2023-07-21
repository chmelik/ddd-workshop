<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Product\Application\Command\CreateProductCommand;
use App\Product\Domain\ValueObject\Currency;
use App\Product\Domain\ValueObject\Decimal;
use App\Product\Domain\ValueObject\DistributionType;
use App\Product\Domain\ValueObject\ProductDescription;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;
use App\Product\Domain\ValueObject\ShopReference;
use App\Product\Domain\ValueObject\Toggle;
use App\Product\Infrastructure\ApiPlatform\Resource\ProductResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

class CreateProductProcessor implements ProcessorInterface
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

        $command = new CreateProductCommand(
            id: new ProductId($data->id),
            shop: new ShopReference($data->shop),
            name: new ProductName($data->name),
            description: new ProductDescription($data->description),
            price: new ProductPrice(
                amount: new Decimal($data->price->amount),
                currency: new Currency($data->price->currency),
            ),
            distributionType: DistributionType::from($data->distributionType),
            enabled: Toggle::fromBool($data->enabled),
        );
        $this->commandBus->dispatch($command);

        return null;
    }
}

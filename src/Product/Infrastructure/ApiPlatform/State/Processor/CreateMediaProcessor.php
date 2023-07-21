<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Product\Application\Command\CreateMediaCommand;
use App\Product\Domain\ValueObject\MediaDescription;
use App\Product\Domain\ValueObject\MediaId;
use App\Product\Domain\ValueObject\MediaName;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Infrastructure\ApiPlatform\Resource\MediaResource;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

class CreateMediaProcessor implements ProcessorInterface
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    /**
     * @param MediaResource $data
     *
     * @return null
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, MediaResource::class);

        $command = new CreateMediaCommand(
            id: new MediaId($data->id),
            product: new ProductId(Uuid::fromString($uriVariables['productId'])),
            name: new MediaName($data->name),
            description: new MediaDescription($data->description),
        );
        $this->commandBus->dispatch($command);

        return null;
    }
}

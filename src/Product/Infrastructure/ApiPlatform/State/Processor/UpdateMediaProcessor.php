<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Product\Application\Command\UpdateMediaCommand;
use App\Product\Domain\ValueObject\MediaDescription;
use App\Product\Domain\ValueObject\MediaId;
use App\Product\Domain\ValueObject\MediaName;
use App\Product\Infrastructure\ApiPlatform\Resource\MediaResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

class UpdateMediaProcessor implements ProcessorInterface
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

        $command = new UpdateMediaCommand(
            id: new MediaId($data->id),
            name: null !== $data->name ? new MediaName($data->name) : null,
            description: null !== $data->description ? new MediaDescription($data->description) : null,
        );
        $this->commandBus->dispatch($command);

        return null;
    }
}

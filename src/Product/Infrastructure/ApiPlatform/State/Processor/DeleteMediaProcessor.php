<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Product\Application\Command\DeleteMediaCommand;
use App\Product\Domain\ValueObject\MediaId;
use App\Product\Infrastructure\ApiPlatform\Resource\MediaResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

class DeleteMediaProcessor implements ProcessorInterface
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

        $this->commandBus->dispatch(new DeleteMediaCommand(
            id: new MediaId($data->id),
        ));

        return null;
    }
}

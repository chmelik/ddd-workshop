<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Product\Application\Query\FindMediaQuery;
use App\Product\Domain\Model\Media;
use App\Product\Domain\ValueObject\MediaId;
use App\Product\Infrastructure\ApiPlatform\Resource\MediaResource;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\Uid\Uuid;

final class MediaItemProvider implements ProviderInterface
{
    public function __construct(private readonly QueryBusInterface $queryBus)
    {
    }

    /**
     * @return MediaResource|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /** @var string $id */
        $id = $uriVariables['id'];

        /** @var Media|null $model */
        $model = $this->queryBus->ask(
            new FindMediaQuery(
                id: new MediaId(Uuid::fromString($id)),
            )
        );

        return null !== $model
            ? MediaResource::fromModel($model)
            : null;
    }
}

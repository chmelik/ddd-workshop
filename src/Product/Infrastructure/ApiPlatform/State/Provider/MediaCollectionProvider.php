<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Product\Application\Query\FindMediasQuery;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Infrastructure\ApiPlatform\Resource\MediaResource;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\Uid\Uuid;

final class MediaCollectionProvider implements ProviderInterface
{
    public function __construct(private readonly QueryBusInterface $queryBus)
    {
    }

    /**
     * @return MediaResource[]
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $query = new FindMediasQuery(
            product: new ProductId(Uuid::fromString($uriVariables['productId'])),
        );
        /** @var array $media */
        $media = $this->queryBus->ask($query);

        $resources = [];
        foreach ($media as $model) {
            $resources[] = MediaResource::fromModel($model);
        }

        return $resources;
    }
}

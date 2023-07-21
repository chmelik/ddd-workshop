<?php

namespace App\Shared\Infrastructure\ApiPlatform\Serializer;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Util\RequestParser;
use App\Shared\Infrastructure\ApiPlatform\Extension\ExtensionInterface;
use App\Shared\Infrastructure\ApiPlatform\Query\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

class SerializerContextBuilder implements SerializerContextBuilderInterface
{
    /**
     * @param iterable|ExtensionInterface[] $extensions
     */
    public function __construct(private readonly SerializerContextBuilderInterface $contextBuilder, private readonly iterable $extensions)
    {
    }

    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null): array
    {
        $context = $this->contextBuilder->createFromRequest($request, $normalization, $extractedAttributes);

        if ($normalization) {
            $context['query_builder'] = $this->getQueryBuilder($request, $context['operation'], $context);
        }

        return $context;
    }

    private function getQueryBuilder(Request $request, Operation $operation, array $context): QueryBuilder
    {
        $queryString = RequestParser::getQueryString($request);
        $filters = $queryString ? RequestParser::parseRequestParams($queryString) : null;

        if ($filters) {
            $context['filters'] = $filters;
        }

        $queryBuilder = new QueryBuilder();
        foreach ($this->extensions as $extension) {
            $extension->apply($queryBuilder, $operation, $context);
        }

        return $queryBuilder;
    }
}

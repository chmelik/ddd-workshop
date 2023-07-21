<?php

namespace App\Shared\Infrastructure\ApiPlatform\Query;

final class QueryBuilder
{
    private array $data = [];

    public function getParameter(string $paramName): mixed
    {
        return $this->data[$paramName] ?? null;
    }

    public function hasParameter(string $paramName): bool
    {
        return array_key_exists($paramName, $this->data);
    }

    public function setParameter(string $paramName, mixed $value): void
    {
        $this->data[$paramName] = $value;
    }
}

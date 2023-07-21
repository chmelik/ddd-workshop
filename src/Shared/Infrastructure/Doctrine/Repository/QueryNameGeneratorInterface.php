<?php

namespace App\Shared\Infrastructure\Doctrine\Repository;

interface QueryNameGeneratorInterface
{
    public function generateJoinAlias(string $association): string;

    public function generateParameterName(string $name): string;
}

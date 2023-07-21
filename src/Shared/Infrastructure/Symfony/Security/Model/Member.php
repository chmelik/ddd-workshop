<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Security\Model;

use Symfony\Component\Uid\AbstractUid;

final class Member
{
    public function __construct(
        private readonly AbstractUid $id,
        private readonly string $name,
    ) {
    }

    public function getId(): AbstractUid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

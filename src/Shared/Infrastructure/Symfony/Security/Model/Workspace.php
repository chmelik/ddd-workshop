<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Security\Model;

use Symfony\Component\Uid\AbstractUid;

final class Workspace
{
    public function __construct(
        private readonly AbstractUid $id,
    ) {
    }

    public function getId(): AbstractUid
    {
        return $this->id;
    }
}

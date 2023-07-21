<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Security\Model;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\AbstractUid;

final class User implements UserInterface
{
    public function __construct(
        private readonly AbstractUid $id,
        private readonly string $userIdentifier,
        private readonly string $name,
        private readonly array $roles,
        private readonly ?Member $member,
        private readonly ?Workspace $workspace,
    ) {
    }

    public function getId(): AbstractUid
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function getWorkspace(): ?Workspace
    {
        return $this->workspace;
    }

    public function eraseCredentials()
    {
        // no-op
    }
}

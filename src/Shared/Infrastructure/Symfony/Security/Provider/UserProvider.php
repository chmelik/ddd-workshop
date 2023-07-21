<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Security\Provider;

use App\Shared\Infrastructure\Symfony\Security\Model\Member;
use App\Shared\Infrastructure\Symfony\Security\Model\User;
use App\Shared\Infrastructure\Symfony\Security\Model\Workspace;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Uid\Uuid;

class UserProvider implements UserProviderInterface
{
    public function loadUserByIdentifier(string $id, string $identifier = '', string $name = '', array $roles = [], ?string $memberId = null, ?string $memberName = null, ?string $workspaceId = null): UserInterface
    {
        return new User(
            id: Uuid::fromString($id),
            userIdentifier: $identifier,
            name: $name,
            roles: $roles,
            member: $memberId && $memberName
                ? new Member(Uuid::fromString($memberId), $memberName)
                : null,
            workspace: $workspaceId
                ? new Workspace(Uuid::fromString($workspaceId))
                : null,
        );
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user; // noop
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }
}

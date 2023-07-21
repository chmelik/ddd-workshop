<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Security\Authenticator;

use App\Shared\Infrastructure\Symfony\Security\Provider\UserProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class InternalHeaderAuthenticator extends AbstractAuthenticator
{
    public function __construct(private readonly UserProvider $userProvider)
    {
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('x-user-id')
            && $request->headers->has('x-user-identifier')
            && $request->headers->has('x-user-name')
            && $request->headers->has('x-user-roles');
    }

    public function authenticate(Request $request): Passport
    {
        $userId = $request->headers->get('x-user-id');
        $userIdentifier = $request->headers->get('x-user-identifier');
        $userName = $request->headers->get('x-user-name');
        $userRoles = explode(',', $request->headers->get('x-user-roles'));

        $memberId = $request->headers->get('x-member-id');
        $memberName = $request->headers->get('x-member-name');

        $workspaceId = $request->headers->get('x-workspace-id');

        return new SelfValidatingPassport(
            new UserBadge($userId,
                function ($userId) use ($userIdentifier, $userName, $userRoles, $memberId, $memberName, $workspaceId) {
                    return $this->loadUser($userId, $userIdentifier, $userName, $userRoles, $memberId, $memberName, $workspaceId);
                })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return null;
    }

    private function loadUser(string $userId, string $userIdentifier, string $userName, array $roles, ?string $memberId, ?string $memberName, ?string $workspaceId): UserInterface
    {
        return $this->userProvider->loadUserByIdentifier($userId, $userIdentifier, $userName, $roles, $memberId, $memberName, $workspaceId);
    }
}

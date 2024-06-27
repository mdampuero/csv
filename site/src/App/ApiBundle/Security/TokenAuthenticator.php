<?php

namespace App\ApiBundle\Security;

use App\ApiBundle\Service\TokenService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    private $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse(['error' => 'Authentication required'], 403);
    }

    public function getCredentials(Request $request)
    {
        $token = $request->headers->get('Authorization');

        if (!$token) {
            return null;
        }

        return [
            'token' => str_replace('Bearer ', '', $token),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $credentials['token'];
        $user = $this->tokenService->validateToken($token);

        if (!$user) {
            throw new CustomUserMessageAuthenticationException('Invalid Token');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null; // Allow the request to continue
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(['error' => 'Authentication Failed'], 403);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}

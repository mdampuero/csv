<?php

namespace App\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthController extends Controller
{
    public function loginCheckAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user) {
            throw new AuthenticationException('Invalid credentials');
        }

        $tokenService = $this->get('app.token_service');
        $token = $tokenService->generateToken($user);

        return new JsonResponse(['token' => $token]);
    }
}
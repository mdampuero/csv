<?php

namespace App\ApiBundle\Service;

use App\BackEndBundle\Entity\AuthToken;
use App\BackEndBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TokenService
{
    private $em;
    private $tokenTtl;

    public function __construct(EntityManagerInterface $em, $tokenTtl)
    {
        $this->em = $em;
        $this->tokenTtl = $tokenTtl;
    }

    public function generateToken(UserInterface $user)
    {
        $token = bin2hex(random_bytes(60));

        $authToken = new AuthToken();
        $authToken->setToken($token);
        $authToken->setUser($user);
        $authToken->setExpiresAt(new \DateTime('+'.$this->tokenTtl.' seconds'));

        $this->em->persist($authToken);
        $this->em->flush();

        return $token;
    }

    public function validateToken($token)
    {
        $authToken = $this->em->getRepository(AuthToken::class)->findOneBy(['token' => $token]);

        if ($authToken && $authToken->getExpiresAt() > new \DateTime()) {
            return $authToken->getUser();
        }

        return null;
    }
}

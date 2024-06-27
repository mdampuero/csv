<?php
// src/ApiBundle/EventSubscriber/ApiHeaderSubscriber.php
namespace App\ApiBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\BackEndBundle\Entity\User;

class ApiHeaderSubscriber implements EventSubscriberInterface
{
    private $jwtSecretKey;
    private $em;

    public function __construct($jwtSecretKey, EntityManagerInterface $em)
    {
        $this->jwtSecretKey = $jwtSecretKey;
        $this->em = $em;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();
        $path = $request->getPathInfo();
        if ($path === '/api/login' || $path === '/api/doc' || strpos($path, '/api') !== 0) {
            return;
        }

        try {
            $authorization = $request->headers->get('Authorization');
            $jwt = str_replace('Bearer ', '', $authorization);
            $decoded = JWT::decode($jwt, new Key($this->jwtSecretKey, 'HS256'));
            $userId = $decoded->user_id;
            $expired = $decoded->exp;
            if ($expired < time())
                throw new \Exception("Token expired");
            if (!$userId)
                throw new \Exception("Token invalid");
            $user = $this->em->getRepository(User::class)->findOneBy([
                "id" => $decoded->user_id,
                "isDelete" => false
            ]);
            if (!$user)
                throw new \Exception("Token invalid");
            $request->headers->set('user', $user->getId());
            return;
        } catch (\Exception $e) {
            $response = new JsonResponse(
                [
                    'message' => $e->getMessage()
                ],
                403
            );
            $event->setResponse($response);
            return;
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}

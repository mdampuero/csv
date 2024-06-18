<?php

namespace App\BackEndBundle\Service;

use App\BackEndBundle\Entity\AuditLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class AuditLogger
{
    private EntityManagerInterface $em;
    private Security $security;
    private RequestStack $requestStack;

    public function __construct(EntityManagerInterface $entityManager, Security $security, RequestStack $requestStack)
    {
        $this->em = $entityManager;
        $this->security = $security;
        $this->requestStack = $requestStack;
    }

    public function log(string $entityType, string $entityId, string $action, array $eventData): void
    {
        $user = $this->security->getUser();
        $request = $this->requestStack->getCurrentRequest();
        $log = new AuditLog;
        $log->setEntityType($entityType);
        $log->setEntityId($entityId);
        $log->setAction($action);
        $log->setEventData($eventData);
        $log->setUser($user);
        $log->setRequestRoute($request->get('_route'));
        $log->setIpAddress($request->getClientIp());
        $log->setCreatedAt(new \DateTime);
        $this->em->persist($log);
        $this->em->flush();
    }
}
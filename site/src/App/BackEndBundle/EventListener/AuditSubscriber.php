<?php

namespace App\BackEndBundle\EventListener;

use App\BackEndBundle\Entity\AuditLog;
use App\BackEndBundle\Service\AuditLogger;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class which listens on Doctrine events and writes an audit log of any entity changes made via Doctrine.
 */
class AuditSubscriber implements EventSubscriber
{
    const EXCLUDE_ENTITIES = ['AuditLog'];
    const EXCLUDE_FIELDS = ['updatedAt', 'currentEvent'];
    private $tokenStorage;
    private $requestStack;
    private $serializer;
    private $removals;
    public function __construct(TokenStorageInterface $tokenStorage, RequestStack $requestStack, SerializerInterface $serializer)
    {
        $this->tokenStorage = $tokenStorage;
        $this->requestStack = $requestStack;
        $this->serializer = $serializer;
    }
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::preRemove,
            Events::postRemove,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        $this->log($entity, 'insert', $entityManager);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        $this->log($entity, 'update', $entityManager);
    }

    // We need to store the entity in a temporary array here, because the entity's ID is no longer
    // available in the postRemove event. We convert it to an array here, so we can retain the ID for 
    // our audit log.
    public function preRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $this->removals[] = $this->serializer->serialize($entity, 'json');
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        //$this->log($entity, 'delete', $entityManager);
    }

    // This is the function which calls the AuditLogger service, constructing
    // the call to `AuditLogger::log()` with the appropriate parameters.
    private function log($entity, string $action, EntityManagerInterface $em): void
    {
        return ;
        $user = "anon.";
        if ($this->tokenStorage->getToken()) {
            $user = $this->tokenStorage->getToken()->getUser();
        }

        $prefix = 'App\BackEndBundle\Entity\\';
        $entityClass = get_class($entity);

        if ($entityClass === $prefix . 'AuditLog' || $user == "anon.") {
            return;
        }
        $entityId = $entity->getId();
        $entityType = str_replace($prefix, '', $entityClass);
        $entityType = str_replace('Proxies\__CG__\Event', 'Event', $entityType);
        $uow = $em->getUnitOfWork();
        if ($action === 'delete') {
            $entityDataString = $this->serializer->serialize($entity, 'json');
        } elseif ($action === 'insert') {
            $entityDataString = $this->serializer->serialize($entity, 'json');
            //$entityDataString = "";
        } else {
            $entityData = $uow->getEntityChangeSet($entity);
            foreach ($entityData as $field => $change) {
                // if($field!='updatedAt')
                $entityData[$field] = [
                    'from' => $change[0],
                    'to' => $change[1],
                ];
            }
            foreach (self::EXCLUDE_FIELDS as $field) {
                unset($entityData[$field]);
            }
            $entityDataString = $this->serializer->serialize($entityData, 'json');
            if (count($entityData) == 0)
                return;
        }

        $log = new AuditLog;
        $log->setEntityType($entityType);
        $log->setEntityId($entityId);
        $log->setAction($action);
        $log->setEventData($entityDataString);
        $log->setUser($user);
        $log->setRequestRoute($this->requestStack->getCurrentRequest()->attributes->get('_route'));
        $log->setIpAddress($this->requestStack->getCurrentRequest()->getClientIp());
        $log->setCreatedAt(new \DateTime);
        $em->persist($log);
        $em->flush();
    }
}
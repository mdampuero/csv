<?php

namespace App\BackEndBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * AuditLog
 *
 * @ORM\Table(name="audit_log")
 * @ORM\Entity(repositoryClass="App\BackEndBundle\Repository\AuditLogRepository")
 */
class AuditLog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="entity_type", type="string", length=255, nullable=true)
     * @Expose
     */
    private $entityType;

    /**
     * @var string
     *
     * @ORM\Column(name="entity_id", type="integer", nullable=true)
     * @Expose
     */
    private $entityId=null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     * @Expose
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255, nullable=true)
     * @Expose
     */
    private $action;

     /**
     * @var string
     *
     * @ORM\Column(name="request_route", type="string", length=255, nullable=true)
     * @Expose
     */
    private $requestRoute;

    /**
     * @var array
     *
     * @ORM\Column(name="event_data", type="text", nullable=true)
     * @Expose
     */
    private $eventData;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=255, nullable=true)
     * @Expose
     */
    private $ipAddress;
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of entityType
     *
     * @return  string
     */ 
    public function getEntityType()
    {
        return $this->entityType;
    }

    /**
     * Set the value of entityType
     *
     * @param  string  $entityType
     *
     * @return  self
     */ 
    public function setEntityType($entityType)
    {
        $this->entityType = $entityType;

        return $this;
    }

    /**
     * Get the value of entityId
     *
     * @return  string
     */ 
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Set the value of entityId
     *
     * @param  string  $entityId
     *
     * @return  self
     */ 
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get the value of createdAt
     *
     * @return  \DateTime
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param  \DateTime  $createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of action
     *
     * @return  string
     */ 
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set the value of action
     *
     * @param  string  $action
     *
     * @return  self
     */ 
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get the value of requestRoute
     *
     * @return  string
     */ 
    public function getRequestRoute()
    {
        return $this->requestRoute;
    }

    /**
     * Set the value of requestRoute
     *
     * @param  string  $requestRoute
     *
     * @return  self
     */ 
    public function setRequestRoute($requestRoute)
    {
        $this->requestRoute = $requestRoute;

        return $this;
    }

    /**
     * Get the value of eventData
     *
     * @return  array
     */ 
    public function getEventData()
    {
        return $this->eventData;
    }

    /**
     * Set the value of eventData
     *
     * @param  string  $eventData
     *
     * @return  self
     */ 
    public function setEventData($eventData)
    {
        $this->eventData = $eventData;

        return $this;
    }

    /**
     * Get the value of ipAddress
     *
     * @return  string
     */ 
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set the value of ipAddress
     *
     * @param  string  $ipAddress
     *
     * @return  self
     */ 
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }
}

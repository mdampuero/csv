<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackEndBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Csv
 *
 * @ORM\Table(name="csv")
 * @ORM\Entity(repositoryClass="App\BackEndBundle\Repository\CsvRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 */

class Csv
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    private $originalName;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    private $file;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Expose
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Expose
     */
    private $updatedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_delete", type="boolean")
     * 
     */
    private $isDelete = false;


    /**
     * Get id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Csv
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Csv
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set isDelete.
     *
     * @param bool $isDelete
     *
     * @return Csv
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete.
     *
     * @return bool
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get the value of file
     */ 
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     */ 
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get the value of originalName
     */ 
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Set the value of originalName
     *
     * @return  self
     */ 
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }
}

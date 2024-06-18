<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackEndBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Class Setting
 *
 * @package App\BackEndBundle\Service
 */
class Setting
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $settings = $this->em->getRepository('AppBackEndBundle:Setting')->find('setting');
        return $settings;
    }

}
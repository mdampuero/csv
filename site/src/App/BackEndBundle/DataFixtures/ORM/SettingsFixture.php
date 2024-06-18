<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackEndBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\BackEndBundle\Entity\Setting;

class SettingsFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

        $setting = new Setting();
        $setting->setId("setting");
        $setting->setTitle("Latam");
        $setting->setCopyright("© " . date('Y') . " - Latam");
        $manager->persist($setting);
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}

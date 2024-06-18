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
use App\BackEndBundle\Entity\User;

class UsersFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName("Superusuario");
        $user->setUsername("admin@email.com");
        $user->setEmail("admin@email.com");
        $user->setPassword('$2y$13$LEs4yEqUr9yCQgPBYGtfiO28rppFXkUBK9NYi35e7gUupHWDS15Ga');
        $user->setRole("ROLE_SUPER");
        $user->setDescription("Super usuario creado automaticamente, se recomienda crear otro usuario con el rol SUPER y elimine este.");
        $user->setIsActive(true);
        $manager->persist($user);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}

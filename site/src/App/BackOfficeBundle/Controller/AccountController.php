<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackOfficeBundle\Controller;

use App\BackEndBundle\Form\User\ProfileType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{

    protected $pathBase = "backoffice_account";

    public function indexAction()
    {
        $entity = $this->get('security.token_storage')->getToken()->getUser();
        return $this->render(
            'AppBackOfficeBundle:Account:index.html.twig',
            array(
                'entity' => $entity,
                'form' => $this->createForm(ProfileType::class, $entity, array(
                    'method' => 'PUT',
                    'action' => $this->generateUrl('api_users_profile', array('id' => $entity->getId()))
                )
                )->createView()
            )
        );
    }

}

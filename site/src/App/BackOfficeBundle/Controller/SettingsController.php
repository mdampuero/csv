<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackOfficeBundle\Controller;

use App\BackEndBundle\Form\Setting\SettingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SettingsController extends Controller
{

    public function indexAction()
    {
        $entity = $this->getDoctrine()->getRepository('AppBackEndBundle:Setting')->find('setting');
        return $this->render('AppBackOfficeBundle:Settings:form.html.twig', array(
            'entity' => $entity,
            'form' => $this->createForm(SettingType::class, $entity, array(
                'method' => 'PUT',
                'action' => $this->generateUrl('api_settings_put', array('id' => 'setting'))
            )
            )->createView()
        )
        );
    }
}

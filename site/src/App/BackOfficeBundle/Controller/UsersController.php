<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackOfficeBundle\Controller;

use App\BackEndBundle\Entity\User;
use App\BackEndBundle\Form\User\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{

    public function indexAction()
    {
        return $this->render(
            'AppBackOfficeBundle:Users:index.html.twig',
            array(
                'formDelete' => $this->createFormBuilder()
                    ->setAction($this->generateUrl('api_users_delete', array('id' => ':ENTITY_ID')))
                    ->setMethod('DELETE')
                    ->getForm()->createView(),
            )
        );
    }

    public function addAction()
    {
        return $this->render('AppBackOfficeBundle:Users:form.html.twig', array('entity' => new User()));
    }

    public function editAction($id)
    {
        return $this->render('AppBackOfficeBundle:Users:form.html.twig', array('entity' => $this->getDoctrine()->getRepository(User::class)->find($id)));
    }

    public function landingAction($id)
    {
        return $this->render('AppBackOfficeBundle:Users:landing.html.twig', array('entity' => $this->getDoctrine()->getRepository(User::class)->find($id),'id' => $id));
    }

    public function getAction($id)
    {
        return $this->render('AppBackOfficeBundle:Users:_partials/get.html.twig', array('entity' => $this->getDoctrine()->getRepository(User::class)->find($id)));
    }

    public function importAction()
    {
        return $this->render(
            'AppBackOfficeBundle:Users:import.html.twig',
            array(
                'form' => $this->createForm(
                    ImportType::class,
                    null,
                    array(
                        'method' => 'POST',
                        'action' => $this->generateUrl('api_users_import')
                    )
                )->createView()
            )
        );
    }

    public function form($entity)
    {
        $method = 'POST';
        $action = $this->generateUrl('api_users_post');
        if ($entity->getId()) {
            $method = 'PUT';
            $action = $this->generateUrl('api_users_put', array('id' => $entity->getId()));
        }
        return $this->render(
            'AppBackOfficeBundle:Users:_partials/form.html.twig',
            array(
                'entity' => $entity,
                'form' => $this->createForm(
                    UserType::class,
                    $entity,
                    array(
                        'method' => $method,
                        'action' => $action
                    )
                )->createView()
            )
        );
    }
}
